<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamDriversRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'drivers' => ['required', 'array'],
            'drivers.*.id' => ['nullable', 'exists:drivers,id'],
            'drivers.*.rating' => ['required_with:id,', 'numeric', 'min:1'],
            'drivers.*.driver_id' => ['nullable', 'max:4'],
        ];
    }
}
