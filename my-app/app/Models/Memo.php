<?php

namespace App\Models;

use Database\Factories\MemoFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Memo extends Model
{
    /** @use HasFactory<MemoFactory> */
    use HasFactory;

    use HasUuids;

    protected $guarded = ['id', 'user_id'];

    protected function casts(): array
    {
        return ['meeting_date' => 'date:Y-m-d', 'letter' => 'array', 'attendees' => 'array', 'ai_raw_json' => 'array', 'version' => 'integer'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function latestAudioJob(): BelongsTo
    {
        return $this->belongsTo(AudioJob::class, 'latest_audio_job_id');
    }

    public function audioJobs(): HasMany
    {
        return $this->hasMany(AudioJob::class);
    }
}
