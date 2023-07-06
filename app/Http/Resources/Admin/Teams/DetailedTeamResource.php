<?php

namespace App\Http\Resources\Admin\Teams;

use App\Http\Resources\Admin\Drivers\BaseDriverResource;
use App\Http\Resources\Admin\Owners\BaseOwnerResource;
use App\Http\Resources\Admin\Series\DetailedSeriesResource;
use App\Models\Team;
use Illuminate\Http\Request;

/** @mixin Team */
class DetailedTeamResource extends BaseTeamResource
{
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'owner_id' => $this->owner_id,
            'series_id' => $this->series_id,
            'owner' => new BaseOwnerResource($this->whenLoaded('owner')),
            'series' => new DetailedSeriesResource($this->whenLoaded('series')),
            'drivers' => BaseDriverResource::collection($this->whenLoaded('drivers')),
        ]);
    }
}
