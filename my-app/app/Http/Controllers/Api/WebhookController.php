<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AudioJob;
use App\Services\ApiResponse;
use App\Services\SummaryHtml;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $secret = (string) config('services.nome.webhook_secret');
        $signature = (string) $request->header('X-Webhook-Signature');
        if (! $secret || ! hash_equals(hash_hmac('sha256', $request->getContent(), $secret), $signature)) {
            return ApiResponse::error('Webhook tidak sah.', 401);
        }
        $data = $request->validate([
            'job_id' => ['required', 'uuid'], 'status' => ['required', 'in:pending,processing,completed,failed'],
            'transcript' => ['nullable', 'string', 'max:2000000'],
            'structured_minutes' => ['required_if:status,completed', 'nullable', 'string', 'max:200000'],
            'error_message' => ['nullable', 'string', 'max:255'],
        ]);

        return DB::transaction(function () use ($data): JsonResponse {
            $job = AudioJob::findOrFail($data['job_id']);
            $memo = $job->memo()->lockForUpdate()->firstOrFail();
            $job->refresh();
            if ($memo->latest_audio_job_id !== $job->id || in_array($job->status, ['completed', 'failed'], true)) {
                return ApiResponse::success(message: 'Webhook sudah diproses atau berasal dari pekerjaan lama.');
            }
            $job->update(['status' => $data['status']]);
            $updates = ['status' => $data['status'], 'error_message' => null, 'version' => $memo->version + 1];
            if ($data['status'] === 'completed') {
                $updates += [
                    'summary_text' => SummaryHtml::clean(Str::markdown($data['structured_minutes'], ['html_input' => 'strip', 'allow_unsafe_links' => false])),
                    'transcript' => $data['transcript'] ?? null, 'ai_raw_json' => $data,
                ];
            } elseif ($data['status'] === 'failed') {
                $updates['error_message'] = $data['error_message'] ?? 'Pemrosesan AI gagal. Silakan unggah ulang audio.';
            }
            $memo->update($updates);

            return ApiResponse::success(['memo_id' => $memo->id, 'status' => $memo->status]);
        });
    }
}
