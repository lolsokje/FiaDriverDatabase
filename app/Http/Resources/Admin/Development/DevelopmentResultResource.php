<?php

namespace App\Http\Resources\Admin\Development;

use App\Http\Resources\Admin\Drivers\BaseDriverResource;
use App\Models\DevelopmentResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin DevelopmentResult */
class DevelopmentResultResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver' => new BaseDriverResource($this->driver),
            'team' => [
                'name' => $this->team?->name ?? 'Free Agent',
                'series' => [
                    'name' => $this->team?->series->name ?? 'N/A',
                    'style' => $this->team?->series->style,
                ],
            ],
            'rating' => $this->rating,
            'dev' => $this->dev,
            'new_rating' => $this->new_rating,
        ];
    }
}
