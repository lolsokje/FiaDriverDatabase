<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'discord_id' => $this->faker->numberBetween(),
            'username' => $this->faker->userName(),
            'admin' => false,
        ];
    }

    public function admin(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'admin' => true,
            ];
        });
    }
}
