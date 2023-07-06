<?php

namespace App\Support;

use Illuminate\Http\Resources\Json\JsonResource;

class UnwrappedJsonResource extends JsonResource
{
    public static $wrap = false;
}
