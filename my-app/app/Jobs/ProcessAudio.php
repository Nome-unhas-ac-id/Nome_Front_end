<?php

namespace App\Jobs;

use App\Models\AudioJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProcessAudio implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public int $tries = 1;

    public int $timeout = 65;

    public function __construct(public string $audioJobId) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $job = AudioJob::with('memo')->find($this->audioJobId);
        if (! $job || ! $job->memo || $job->memo->latest_audio_job_id !== $job->id || $job->status !== 'processing') {
            return;
        }
        $stream = Storage::disk('local')->readStream($job->path);
        try {
            $response = Http::acceptJson()->withToken((string) config('services.nome.api_key'))
                ->timeout(55)->connectTimeout(10)->withHeaders(['Idempotency-Key' => $job->id])
                ->attach('audio', $stream, basename($job->path))
                ->post(config('services.nome.url'), [
                    'job_id' => $job->id,
                    'callback_url' => config('services.nome.callback_url') ?: url('/api/webhooks/nome-callback'),
                ]);
            $response->throw();
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }
        }
    }

    public function failed(?\Throwable $exception): void
    {
        DB::transaction(function (): void {
            $job = AudioJob::find($this->audioJobId);
            if (! $job) {
                return;
            }
            $memo = $job->memo()->lockForUpdate()->first();
            if ($memo && $memo->latest_audio_job_id === $job->id && in_array($memo->status, ['pending', 'processing'], true)) {
                $job->update(['status' => 'failed']);
                $memo->update(['status' => 'failed', 'error_message' => 'Layanan AI tidak dapat menerima audio. Silakan unggah ulang.', 'version' => $memo->version + 1]);
            }
        });
    }
}
