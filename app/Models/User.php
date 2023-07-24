<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends AuthenticatableSnowflake
{
    use HasFactory;

    protected $casts = [
        'admin' => 'boolean',
    ];

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class);
    }
}
