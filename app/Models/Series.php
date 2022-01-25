<?php

namespace App\Models;

use App\Traits\Snowflake;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Series extends Model
{
    use HasFactory, Snowflake;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'style',
    ];

    public function style(): Attribute
    {
        return Attribute::get(function () {
            return "background-color:$this->background_colour;color:$this->text_colour;text-align:center;font-weight:bold";
        });
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
}
