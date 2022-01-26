<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'dob' => $this->faker->date(),
            'rating' => $this->faker->numberBetween(1, 100),
        ];
    }

    public function freeAgent()
    {
        return $this->state(function (array $attributes) {
            return [
                'team_id' => null,
            ];
        });
    }
}
