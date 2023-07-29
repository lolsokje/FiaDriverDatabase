<?php

namespace App\Http\Resources\Admin\Engines;

use App\Http\Resources\Admin\Series\SeriesIndexResource;
use App\Models\Engine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Engine */
class EngineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'series_id' => $this->series_id,
            'name' => $this->name,
            'series' => new SeriesIndexResource($this->whenLoaded('series')),
        ];
    }
}
