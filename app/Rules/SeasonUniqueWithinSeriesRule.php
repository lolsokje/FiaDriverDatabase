<?php

namespace App\Rules;

use App\Models\Season;
use App\Models\Series;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

readonly class SeasonUniqueWithinSeriesRule implements ValidationRule
{
    public function __construct(
        private Series $series,
        private ?Season $season = null,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Season::query()
            ->where('series_id', $this->series->id)
            ->where('year', $value);

        if ($this->season) {
            $query->whereNot('id', $this->season->id);
        }

        $count = $query->count();

        if ($count > 0) {
            $fail('The year is already used within the selected series.');
        }
    }
}
