<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DriverCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::check('is-admin');
    }

    public function rules(): array
    {
        return [
            'team_id' => ['nullable', 'exists:teams,id'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'dob' => ['required', 'date'],
            'rating' => ['required', 'integer', 'min:0'],
            'driver_id' => ['nullable', 'max:4'],
        ];
    }
}
