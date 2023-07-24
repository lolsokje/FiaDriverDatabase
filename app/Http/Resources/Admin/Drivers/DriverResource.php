<?php

namespace App\Http\Resources\Admin\Drivers;

use App\Http\Resources\DateResource;
use App\Http\Resources\UserResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Driver */
class DriverResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'dob' => new DateResource($this->dob),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
