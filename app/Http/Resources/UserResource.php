<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'username'         => $this->username,
            'email'            => $this->email,
            'progress'         => $this->whenPivotLoaded('collections', fn () => $this->pivot->progress),
            'collection_count' => $this->whenCounted('collection'),
            'collection'       => CollectionItemResource::collection($this->whenLoaded('collection')),
        ];
    }
}
