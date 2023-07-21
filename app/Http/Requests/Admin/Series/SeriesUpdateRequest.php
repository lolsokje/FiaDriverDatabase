<?php

namespace App\Http\Requests\Admin\Series;

use App\Models\Series;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeriesUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var Series $series */
        $series = $this->route('series');

        return [
            'name' => ['required', Rule::unique('series')->ignoreModel($series)],
            'primary_colour' => ['required'],
            'secondary_colour' => ['required'],
        ];
    }
}
