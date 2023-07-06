<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Owner extends SnowflakeModel
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function drivers(): HasManyThrough
    {
        return $this->hasManyThrough(Driver::class, Team::class);
    }
}
