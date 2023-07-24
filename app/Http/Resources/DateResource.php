<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/** @mixin Carbon */
class DateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'raw' => $this->format('Y-m-d'),
            'formatted' => $this->format('F dS, Y'),
        ];
    }
}
