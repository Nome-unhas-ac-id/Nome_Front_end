<?php

use App\Models\Memo;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('nome:user {email} {--name=}', function (): int {
    $email = strtolower(trim($this->argument('email')));
    $name = $this->option('name') ?: $this->ask('Nama lengkap');
    $password = $this->secret('Kata sandi baru (minimal 12 karakter)');
    $confirm = $this->secret('Ulangi kata sandi');
    $data = validator(['email' => $email, 'name' => $name, 'password' => $password, 'password_confirmation' => $confirm], [
        'email' => ['required', 'email', 'unique:users,email'],
        'name' => ['required', 'string', 'max:255'],
        'password' => ['required', 'string', 'min:12', 'confirmed'],
    ])->validate();
    User::create(Arr::only($data, ['name', 'email', 'password']));
    $this->info('Akun berhasil dibuat.');

    return 0;
})->purpose('Create a Nome login account without public registration or roles');

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
