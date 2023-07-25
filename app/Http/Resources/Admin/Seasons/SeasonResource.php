<?php

namespace App\Http\Resources\Admin\Seasons;

use App\Http\Resources\Admin\Series\SeriesIndexResource;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Season */
class SeasonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'series' => new SeriesIndexResource($this->whenLoaded('series')),
        ];
    }
}
