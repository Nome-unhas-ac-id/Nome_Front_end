<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemoRequest;
use App\Http\Resources\MemoResource;
use App\Models\Memo;
use App\Services\ApiResponse;
use App\Services\MemoExport;
use App\Services\SummaryHtml;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MemoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:draft,pending,processing,completed,failed'],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', ...($request->filled('date_from') ? ['after_or_equal:date_from'] : [])],
            'per_page' => ['nullable', 'integer', 'between:1,50'], 'page' => ['nullable', 'integer', 'min:1'],
        ]);
        $query = $request->user()->memos()->select([
            'id', 'user_id', 'title', 'meeting_date', 'meeting_time', 'meeting_end_time', 'location',
            'leader_name', 'notetaker_name', 'letter', 'attendees', 'status', 'error_message', 'version', 'created_at', 'updated_at',
        ]);
        if ($filters['search'] ?? null) {
            $query->where(function ($query) use ($filters): void {
                foreach (['title', 'location', 'leader_name', 'notetaker_name', 'agenda'] as $field) {
                    $query->orWhere($field, 'like', '%'.$filters['search'].'%');
                }
            });
        }
        if ($filters['status'] ?? null) {
            $query->where('status', $filters['status']);
        }
        if ($filters['date_from'] ?? null) {
            $query->whereDate('meeting_date', '>=', $filters['date_from']);
        }
        if ($filters['date_to'] ?? null) {
            $query->whereDate('meeting_date', '<=', $filters['date_to']);
        }
        $page = $query->orderByDesc('meeting_date')->orderByDesc('created_at')->orderBy('id')->paginate($filters['per_page'] ?? 15);

        return ApiResponse::success([
            'items' => $page->getCollection()->map(fn (Memo $memo) => (new MemoResource($memo))->resolve($request))->all(),
            'meta' => ['current_page' => $page->currentPage(), 'per_page' => $page->perPage(), 'total' => $page->total(), 'last_page' => $page->lastPage()],
        ]);
    }

    public function store(MemoRequest $request): JsonResponse
    {
        $memo = $request->user()->memos()->create(Arr::except($request->validated(), ['version']) + ['status' => 'draft']);

        return ApiResponse::success((new MemoResource($memo->load('latestAudioJob')))->resolve($request), 'Memo berhasil dibuat.', 201);
    }

    public function show(Request $request, string $memo): JsonResponse
    {
        $record = $request->user()->memos()->with('latestAudioJob')->findOrFail($memo);

        return ApiResponse::success((new MemoResource($record))->resolve($request));
    }

    public function update(MemoRequest $request, string $memo): JsonResponse
    {
        $record = DB::transaction(function () use ($request, $memo): Memo {
            $record = $request->user()->memos()->lockForUpdate()->findOrFail($memo);
            abort_if(in_array($record->status, ['pending', 'processing'], true), 409, 'Memo sedang diproses. Tunggu sebelum menyunting.');
            $data = $request->validated();
            unset($data['version']);
            if (array_key_exists('summary_text', $data)) {
                $data['summary_text'] = SummaryHtml::clean($data['summary_text']);
            }
            if (isset($data['letter']) && is_array($record->letter)) {
                $data['letter'] = array_replace($record->letter, $data['letter']);
            }
            $record->fill($data);
            $record->version++;
            $record->save();

            return $record->load('latestAudioJob');
        });

        return ApiResponse::success((new MemoResource($record))->resolve($request), 'Memo berhasil diperbarui.');
    }

    public function destroy(Request $request, string $memo): JsonResponse
    {
        $paths = DB::transaction(function () use ($request, $memo): array {
            $record = $request->user()->memos()->lockForUpdate()->findOrFail($memo);
            abort_if(in_array($record->status, ['pending', 'processing'], true), 409, 'Tunggu pemrosesan selesai sebelum menghapus memo.');
            $paths = $record->audioJobs()->pluck('path')->all();
            $record->delete();

            return $paths;
        });
        Storage::disk('local')->delete($paths);

        return ApiResponse::success(message: 'Memo berhasil dihapus.');
    }

    public function preview(Request $request, string $memo): JsonResponse
    {
        $record = $request->user()->memos()->findOrFail($memo);
        $data = (new MemoResource($record))->resolve($request);
        $data['meeting_date_label'] = $record->meeting_date->locale('id')->translatedFormat('l, d F Y');
        $data['meeting_time_label'] = $data['meeting_time'] ? $data['meeting_time'].' WITA' : null;

        return ApiResponse::success([
            'memo' => Arr::except($data, ['letter', 'attendees', 'summary_text', 'transcript', 'ai_raw_json']),
            'letter' => $record->letter === null ? null : (object) $record->letter,
            'attendees' => collect($record->attendees ?? [])->values()->map(fn (array $person, int $index) => ['no' => $index + 1] + $person)->all(),
            'summary_html' => SummaryHtml::clean($record->summary_text), 'transcript' => $record->transcript,
            'ai_raw_json' => $record->ai_raw_json, 'can_export' => $record->status === 'completed',
        ]);
    }

    public function export(Request $request, string $memo, string $type, MemoExport $export): Response
    {
        $record = $request->user()->memos()->findOrFail($memo);
        abort_unless($record->status === 'completed', 409, 'Memo belum selesai diproses, belum dapat diekspor.');

        return $export->download($record, $type);
    }
}
