<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends SnowflakeModel
{
    use HasFactory;

    protected $casts = [
        'dob' => 'date',
    ];

    protected $appends = [
        'full_name',
    ];

    public function fullName(): Attribute
    {
        return Attribute::get(fn () => "$this->first_name $this->last_name");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
