<?php

namespace App\Http\Requests\Admin\Series;

use Illuminate\Foundation\Http\FormRequest;

class SeriesCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:series'],
            'primary_colour' => ['required'],
            'secondary_colour' => ['required'],
        ];
    }
}
