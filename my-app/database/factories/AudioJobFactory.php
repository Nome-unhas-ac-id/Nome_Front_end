<?php

namespace Database\Factories;

use App\Models\AudioJob;
use App\Models\Memo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AudioJob>
 */
class AudioJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'memo_id' => Memo::factory(),
            'path' => 'audio/test.wav',
            'file_size' => 1000,
            'status' => 'processing',
        ];
    }
}
