<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'type'         => $this->type,
            'type_label'   => $this->getTypeLabel(),
            'release_year' => $this->release_year,
            'rating'       => $this->rating,
            'genres'       => $this->genres ?? [],
            'total_units'  => $this->getTotalUnits() . ' ' . $this->getUnitLabel(),
            'details'      => $this->extraInfo(),
            'action'       => $this->getActionVerb() . ' sekarang di FlipPlay',

            // Relasi: hanya muncul kalau di-load
            'collected_by' => UserResource::collection($this->whenLoaded('users')),
        ];
    }

    // Pengganti getExtraInfo() yang dulu di-override tiap child class
    private function extraInfo(): array
    {
        return match ($this->type) {
            'anime' => [
                'episodes'             => $this->episodes,
                'minutes_per_episode'  => $this->minutes_per_episode,
                'total_duration_hours' => $this->getTotalDurationHours(),
                'studio'               => $this->studio,
            ],
            'drama' => [
                'episodes'             => $this->episodes,
                'minutes_per_episode'  => $this->minutes_per_episode,
                'total_duration_hours' => $this->getTotalDurationHours(),
                'country'              => $this->country,
            ],
            'manga' => [
                'author'   => $this->author,
                'chapters' => $this->chapters,
                'status'   => $this->is_ongoing ? 'Ongoing' : 'Tamat',
            ],
            'light_novel' => [
                'author'   => $this->author,
                'chapters' => $this->chapters,
                'volumes'  => $this->volumes,
            ],
            default => [],
        };
    }
}
