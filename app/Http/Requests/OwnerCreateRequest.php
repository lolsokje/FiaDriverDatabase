<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class OwnerCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::check('is-admin');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:owners,name'],
        ];
    }
}
