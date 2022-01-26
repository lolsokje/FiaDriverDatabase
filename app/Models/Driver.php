<?php

namespace App\Models;

use App\Traits\Snowflake;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    use HasFactory, Snowflake;

    protected $appends = [
        'owner',
        'series',
        'full_name',
        'date_of_birth',
    ];

    protected $casts = [
        'rating' => 'integer',
        'dob' => 'date:Y-m-d',
    ];

    public function fullName(): Attribute
    {
        return Attribute::get(fn() => trim("$this->first_name $this->last_name"));
    }

    public function dateOfBirth(): Attribute
    {
        return Attribute::get(fn() => $this->dob->format('m/d/Y'));
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function owner(): Attribute
    {
        return Attribute::get(fn() => $this->team->owner);
    }

    public function series(): Attribute
    {
        return Attribute::get(fn() => $this->team->series);
    }
}
