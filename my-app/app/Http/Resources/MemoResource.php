<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id, 'user_id' => $this->user_id, 'title' => $this->title,
            'meeting_date' => $this->meeting_date->format('Y-m-d'),
            'meeting_time' => $this->meeting_time ? substr($this->meeting_time, 0, 5) : null,
            'meeting_end_time' => $this->meeting_end_time ? substr($this->meeting_end_time, 0, 5) : null,
            'location' => $this->location, 'leader_name' => $this->leader_name, 'notetaker_name' => $this->notetaker_name,
            'status' => $this->status, 'error_message' => $this->error_message, 'version' => $this->version,
            'created_at' => $this->created_at?->toISOString(), 'updated_at' => $this->updated_at?->toISOString(),
        ];
        if (! $request->routeIs('api.memos.index')) {
            $data += [
                'agenda' => $this->agenda, 'letter' => $this->letter === null ? null : (object) $this->letter, 'attendees' => $this->attendees ?? [],
                'summary_text' => $this->summary_text, 'transcript' => $this->transcript, 'ai_raw_json' => $this->ai_raw_json,
                'latest_audio_job' => $this->whenLoaded('latestAudioJob', fn () => $this->latestAudioJob ? [
                    'job_id' => $this->latestAudioJob->id, 'status' => $this->latestAudioJob->status,
                    'file_size' => $this->latestAudioJob->file_size, 'updated_at' => $this->latestAudioJob->updated_at->toISOString(),
                ] : null),
            ];
        }

        return $data;
    }
}
