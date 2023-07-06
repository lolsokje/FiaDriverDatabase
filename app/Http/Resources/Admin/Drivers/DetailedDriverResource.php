<?php

namespace App\Http\Resources\Admin\Drivers;

use App\Http\Resources\Admin\Owners\BaseOwnerResource;
use App\Http\Resources\Admin\Series\DetailedSeriesResource;
use App\Http\Resources\Admin\Teams\DetailedTeamResource;
use App\Models\Driver;
use Illuminate\Http\Request;

/** @mixin Driver */
class DetailedDriverResource extends BaseDriverResource
{
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'team_id' => $this->team_id,
            'owner' => new BaseOwnerResource($this->owner),
            'series' => new DetailedSeriesResource($this->series),
            'team' => new DetailedTeamResource($this->whenLoaded('team')),
        ]);
    }
}
