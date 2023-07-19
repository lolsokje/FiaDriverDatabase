<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends AuthenticatableSnowflake
{
    use HasFactory;

    protected $casts = [
        'admin' => 'boolean',
    ];
}
