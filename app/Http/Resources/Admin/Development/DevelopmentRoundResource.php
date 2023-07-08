<?php

namespace App\Http\Resources\Admin\Development;

use App\Models\DevelopmentRound;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin DevelopmentRound */
class DevelopmentRoundResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'created_at' => $this->created_at->format('F jS, Y H:i'),
        ];
    }
}
