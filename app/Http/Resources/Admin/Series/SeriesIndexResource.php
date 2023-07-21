<?php

namespace App\Http\Resources\Admin\Series;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Series */
class SeriesIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'primary_colour' => $this->primary_colour,
            'secondary_colour' => $this->secondary_colour,
        ];
    }
}
