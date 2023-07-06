<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class OwnerUpdateRequest extends FormRequest
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
                Rule::unique('owners', 'name')->ignore($this->route('owner')),
            ],
        ];
    }
}
