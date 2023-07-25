<?php

namespace App\Http\Requests\Admin\Seasons;

use App\Models\Season;
use App\Models\Series;
use App\Rules\SeasonUniqueWithinSeriesRule;
use Illuminate\Foundation\Http\FormRequest;

class SeasonUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var Series $series */
        /** @var Season $season */
        $series = $this->route('series');
        $season = $this->route('season');

        return [
            'year' => [
                'required',
                'numeric',
                'min:1900',
                'max:2100',
                new SeasonUniqueWithinSeriesRule($series, $season),
            ],
        ];
    }
}
