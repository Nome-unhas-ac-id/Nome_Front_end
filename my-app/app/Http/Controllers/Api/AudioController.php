<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessAudio;
use App\Services\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function upload(Request $request, string $memo): JsonResponse
    {
        $request->user()->memos()->findOrFail($memo);
        $request->validate(['audio' => ['required', 'file', 'mimes:mp3,wav,m4a,ogg', 'extensions:mp3,wav,m4a,ogg', 'max:102400']]);
        if (! config('services.nome.url') || ! config('services.nome.webhook_secret')) {
            return ApiResponse::error('Layanan AI belum dikonfigurasi. Memo dan hasil sebelumnya tetap tersimpan.', 503);
        }
        $path = $request->file('audio')->store('audio/'.$request->user()->id, 'local');
        try {
            $job = DB::transaction(function () use ($request, $memo, $path) {
                $record = $request->user()->memos()->lockForUpdate()->findOrFail($memo);
                abort_if(in_array($record->status, ['pending', 'processing'], true), 409, 'Memo sedang diproses. Tunggu sampai selesai.');
                $job = $record->audioJobs()->create(['path' => $path, 'file_size' => $request->file('audio')->getSize(), 'status' => 'processing']);
                $record->update(['status' => 'processing', 'error_message' => null, 'latest_audio_job_id' => $job->id, 'version' => $record->version + 1]);

                return $job;
            });
        } catch (\Throwable $error) {
            Storage::disk('local')->delete($path);
            throw $error;
        }
        try {
            ProcessAudio::dispatch($job->id)->afterCommit();
        } catch (\Throwable $error) {
            report($error);
            (new ProcessAudio($job->id))->failed($error);

            return ApiResponse::error('Audio belum dapat diproses. Silakan coba lagi.', 503);
        }

        return ApiResponse::success(['memo_id' => $memo, 'job_id' => $job->id, 'status' => 'processing'], 'Audio diterima dan sedang diproses.', 202);
    }

    public function status(Request $request, string $memo): JsonResponse
    {
        $record = $request->user()->memos()->with('latestAudioJob')->findOrFail($memo);
        $job = $record->latestAudioJob;

        return ApiResponse::success([
            'memo_id' => $record->id, 'status' => $record->status, 'error_message' => $record->error_message,
            'has_summary' => filled($record->summary_text),
            'audio_job' => $job ? ['job_id' => $job->id, 'status' => $job->status, 'file_size' => $job->file_size, 'updated_at' => $job->updated_at->toISOString()] : null,
        ]);
    }
}
