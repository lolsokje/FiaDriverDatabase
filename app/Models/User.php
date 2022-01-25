<?php

namespace App\Models;

use App\Traits\Snowflake;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Snowflake;
}
