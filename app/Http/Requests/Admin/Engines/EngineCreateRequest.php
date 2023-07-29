<?php

namespace App\Http\Requests\ADmin\Engines;

use Illuminate\Foundation\Http\FormRequest;

class EngineCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }
}
