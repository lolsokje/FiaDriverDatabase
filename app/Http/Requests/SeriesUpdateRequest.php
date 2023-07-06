<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class SeriesUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::check('is-admin');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('series', 'name')->ignore($this->route('series')),
            ],
            'background_colour' => ['nullable'],
            'text_colour' => ['nullable'],
        ];
    }
}
