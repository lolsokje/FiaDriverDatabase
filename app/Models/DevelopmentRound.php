<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DevelopmentRound extends SnowflakeModel
{
    use HasFactory;

    public function developmentResults(): HasMany
    {
        return $this->hasMany(DevelopmentResult::class);
    }
}
