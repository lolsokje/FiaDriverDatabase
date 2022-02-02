<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DevRangesCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::check('is-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ageRanges' => ['required'],
            'ageRanges.*.ranges' => ['required'],
            'ageRanges.*.ranges.*.min_rating' => ['required', 'integer', 'min:0'],
            'ageRanges.*.ranges.*.max_rating' => ['required', 'integer', 'min:0'],
            'ageRanges.*.ranges.*.min_dev' => ['required', 'integer'],
            'ageRanges.*.ranges.*.max_dev' => ['required', 'integer'],
        ];
    }
}
