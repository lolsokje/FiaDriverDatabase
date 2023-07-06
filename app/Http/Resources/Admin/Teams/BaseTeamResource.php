<?php

namespace App\Http\Resources\Admin\Teams;

use App\Models\Team;
use App\Support\UnwrappedJsonResource;
use Illuminate\Http\Request;

/** @mixin Team */
class BaseTeamResource extends UnwrappedJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
