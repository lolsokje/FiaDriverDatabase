<?php

namespace App\Http\Resources\Admin\Drivers;

use App\Models\Driver;
use App\Support\UnwrappedJsonResource;
use Illuminate\Http\Request;

/** @mixin Driver */
class BaseDriverResource extends UnwrappedJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'rating' => $this->rating,
            'dob' => $this->dob->format('Y-m-d'),
            'date_of_birth' => $this->date_of_birth,
            'age' => $this->age,
            'team_id' => $this->team_id,
        ];
    }
}
