<?php

namespace App\Models;

use App\Traits\Snowflake;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgeRange extends Model
{
    use HasFactory, Snowflake;

    public function ranges(): HasMany
    {
        return $this->hasMany(DevRange::class);
    }
}
