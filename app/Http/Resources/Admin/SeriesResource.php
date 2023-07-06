<?php

namespace App\Http\Resources\Admin;

use App\Models\Series;
use App\Support\UnwrappedJsonResource;
use Illuminate\Http\Request;

/** @mixin Series */
class SeriesResource extends UnwrappedJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
