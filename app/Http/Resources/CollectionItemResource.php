<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $progress = (int) $this->pivot->progress;
        $total = $this->getTotalUnits();

        return [
            'media_id'   => $this->id,
            'title'      => $this->title,
            'type_label' => $this->getTypeLabel(),
            'progress'   => $progress,
            'total'      => $total,
            'unit'       => $this->getUnitLabel(),
            'percentage' => $total === 0 ? 0 : (int) round($progress / $total * 100),
            'status'     => match (true) {
                $progress === 0     => 'Belum dimulai',
                $progress >= $total => 'Selesai',
                default             => 'Sedang di' . strtolower($this->getActionVerb()),
            },
        ];
    }
}
