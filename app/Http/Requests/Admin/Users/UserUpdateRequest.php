<?php

namespace App\Http\Requests\Admin\Users;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var User $user */
        $user = $this->route('user');

        return [
            'username' => ['required', Rule::unique('users')->ignoreModel($user)],
            'discord_id' => ['required', Rule::unique('users')->ignoreModel($user)],
        ];
    }
}
