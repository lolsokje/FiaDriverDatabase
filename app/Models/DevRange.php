<?php

namespace App\Models;

use App\Traits\Snowflake;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevRange extends Model
{
    use HasFactory, Snowflake;

    public function ageRange(): BelongsTo
    {
        return $this->belongsTo(AgeRange::class);
    }
}
