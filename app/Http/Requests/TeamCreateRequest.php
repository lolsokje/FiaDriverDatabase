<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TeamCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::check('is-admin');
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'series_id' => ['required', 'exists:series,id'],
            'owner_id' => ['required', 'exists:owners,id'],
            'team_id' => ['nullable', 'max:4'],
        ];
    }
}
