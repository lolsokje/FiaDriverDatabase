<?php

namespace App\Http\Requests;

use App\Http\ValueObjects\DevelopmentDriver;
use Illuminate\Foundation\Http\FormRequest;

class RatingUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'drivers' => ['required', 'array'],
            'drivers.*.id' => ['required', 'exists:drivers,id'],
            'drivers.*.rating' => ['required', 'numeric', 'min:1'],
            'drivers.*.dev' => ['required', 'numeric'],
            'drivers.*.new_rating' => ['required', 'numeric'],
        ];
    }

    /**
     * @return DevelopmentDriver[]
     */
    public function drivers(): array
    {
        return array_map(function (array $driver) {
            return new DevelopmentDriver(
                $driver['id'],
                $driver['rating'],
                $driver['dev'],
                $driver['new_rating']
            );
        }, $this->validated('drivers'));
    }
}
