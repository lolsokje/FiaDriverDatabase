<?php

namespace App\Http\Resources\Admin\Teams;

use App\Http\Resources\Admin\Series\SeriesIndexResource;
use App\Http\Resources\UserResource;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Team */
class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'series' => new SeriesIndexResource($this->whenLoaded('series')),
            'user' => new UserResource($this->whenLoaded('user')),
            'full_name' => $this->full_name,
            'short_name' => $this->short_name,
            'primary_colour' => $this->primary_colour,
            'secondary_colour' => $this->secondary_colour,
        ];
    }
}
