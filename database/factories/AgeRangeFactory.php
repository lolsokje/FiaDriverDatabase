<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AgeRangeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $minAge = $this->faker->numberBetween(14, 30);
        return [
            'min_age' => $minAge,
            'max_age' => $this->faker->numberBetween($minAge, $minAge + 10),
        ];
    }
}
