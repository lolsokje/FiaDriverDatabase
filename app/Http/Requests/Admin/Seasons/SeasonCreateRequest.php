<?php

namespace App\Http\Requests\Admin\Seasons;

use App\Models\Series;
use App\Rules\SeasonUniqueWithinSeriesRule;
use Illuminate\Foundation\Http\FormRequest;

class SeasonCreateRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var Series $series */
        $series = $this->route('series');

        return [
            'year' => [
                'required',
                'numeric',
                'min:1900',
                'max:2100',
                new SeasonUniqueWithinSeriesRule($series),
            ],
        ];
    }
}
