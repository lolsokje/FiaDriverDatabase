<?php

namespace App\Http\Requests\Admin\Drivers;

use App\Rules\FirstAndLastNameUniqueRule;
use Illuminate\Foundation\Http\FormRequest;

class DriverUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'first_name' => ['required', new FirstAndLastNameUniqueRule($this->route('driver'))],
            'last_name' => ['required'],
            'dob' => ['required', 'date'],
        ];
    }
}
