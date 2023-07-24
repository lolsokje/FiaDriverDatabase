<?php

namespace App\Rules;

use App\Models\Driver;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class FirstAndLastNameUniqueRule implements ValidationRule, DataAwareRule
{
    private array $data = [];

    public function __construct(
        private readonly ?Driver $driver = null,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Driver::query()
            ->where('first_name', $this->data['first_name'])
            ->where('last_name', $this->data['last_name']);

        if ($this->driver) {
            $query->whereNot('id', $this->driver->id);
        }

        $count = $query->count();

        if ($count > 0) {
            $fail('A driver with this full name already exists.');
        }
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
