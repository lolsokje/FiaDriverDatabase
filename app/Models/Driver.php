<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Driver extends SnowflakeModel
{
    use HasFactory;

    protected $appends = [
        'owner',
        'series',
        'full_name',
        'date_of_birth',
        'age',
    ];

    protected $casts = [
        'rating' => 'integer',
        'dob' => 'date:Y-m-d',
    ];

    public function fullName(): Attribute
    {
        return Attribute::get(fn () => trim("$this->first_name $this->last_name"));
    }

    public function dateOfBirth(): Attribute
    {
        return Attribute::get(fn () => $this->dob->format('d/m/Y'));
    }

    public function age(): Attribute
    {
        return Attribute::get(function () {
            $year = resolve('general_settings')->year;

            return $this->dob->diff(new DateTime("01-03-$year"))->y;
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function owner(): Attribute
    {
        return Attribute::get(fn () => $this->team?->owner);
    }

    public function series(): HasOneThrough
    {
        return $this->hasOneThrough(Series::class, Team::class, 'id', 'id', 'team_id', 'series_id');
    }
    //    public function series(): Attribute
    //    {
    //        return Attribute::get(fn () => $this->team?->series);
    //    }

    public function scopeWithoutFreeAgents(Builder $query): Builder
    {
        return $query->whereNotNull('team_id');
    }

    public function scopeFreeAgents(Builder $query): Builder
    {
        return $query->whereNull('team_id');
    }

    public function scopeSortedBySeries(Builder $query): array
    {
        return $query
            ->with(['team' => fn (BelongsTo $relation) => $relation->orderBy('name'), 'team.series', 'team.owner'])
            ->get()
            ->sort(function ($a, $b) {
                if (! isset($a['series'])) {
                    return true;
                }

                if (! isset($b['series'])) {
                    return false;
                }

                return $a['series']['name'] > $b['series']['name'];
            })
            ->values()
            ->all();
    }
}
