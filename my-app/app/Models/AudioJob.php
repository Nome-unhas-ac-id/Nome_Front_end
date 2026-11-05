<?php

namespace App\Models;

use Database\Factories\AudioJobFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AudioJob extends Model
{
    /** @use HasFactory<AudioJobFactory> */
    use HasFactory;

    use HasUuids;

    protected $guarded = ['id'];

    public function memo(): BelongsTo
    {
        return $this->belongsTo(Memo::class);
    }
}
