<?php

use App\Models\Memo;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('nome:expire-jobs', function (): void {
    Memo::whereIn('status', ['pending', 'processing'])
        ->where('updated_at', '<', now()->subMinutes(config('services.nome.job_timeout_minutes')))
        ->eachById(function (Memo $memo): void {
            DB::transaction(function () use ($memo): void {
                $current = Memo::lockForUpdate()->find($memo->id);
                if (! $current || ! in_array($current->status, ['pending', 'processing'], true)
                    || $current->updated_at->greaterThanOrEqualTo(now()->subMinutes(config('services.nome.job_timeout_minutes')))) {
                    return;
                }
                $current->latestAudioJob?->update(['status' => 'failed']);
                $current->update(['status' => 'failed', 'error_message' => 'Batas waktu pemrosesan terlampaui. Silakan unggah ulang.', 'version' => $current->version + 1]);
            });
        });
})->purpose('Release audio jobs that never received a callback');

Schedule::command('nome:expire-jobs')->everyMinute()->withoutOverlapping();
Schedule::command('sanctum:prune-expired --hours=24')->daily();
