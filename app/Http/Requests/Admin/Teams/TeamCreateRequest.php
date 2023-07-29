<?php

namespace App\Http\Requests\Admin\Teams;

use Illuminate\Foundation\Http\FormRequest;

class TeamCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => ['required'],
            'short_name' => ['required'],
            'primary_colour' => ['required'],
            'secondary_colour' => ['required'],
        ];
    }
}
