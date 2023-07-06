<?php

namespace App\Http\Resources\Admin\Series;

use App\Models\Series;
use Illuminate\Http\Request;

/** @mixin Series */
class DetailedSeriesResource extends BaseSeriesResource
{
    public function toArray(Request $request): array
    {
        return array_merge(parent::toArray($request), [
            'background_colour' => $this->background_colour,
            'text_colour' => $this->text_colour,
        ]);
    }
}
