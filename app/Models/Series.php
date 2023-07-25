<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends SnowflakeModel
{
    use HasFactory;

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }
}
