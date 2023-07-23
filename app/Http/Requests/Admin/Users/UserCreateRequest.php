<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'unique:users'],
            'discord_id' => ['required', 'unique:users'],
        ];
    }
}
