<?php

namespace Database\Factories;

use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'primary_colour' => $this->faker->safeHexColor(),
            'secondary_colour' => $this->faker->safeHexColor(),
        ];
    }
}
