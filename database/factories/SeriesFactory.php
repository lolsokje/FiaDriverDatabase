<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'background_colour' => $this->faker->safeHexColor(),
            'text_colour' => $this->faker->safeHexColor(),
        ];
    }
}
