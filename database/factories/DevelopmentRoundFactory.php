<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DevelopmentRoundFactory extends Factory
{
    public function definition(): array
    {
        return [
            'year' => fake()->numberBetween(2000, date('Y')),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
