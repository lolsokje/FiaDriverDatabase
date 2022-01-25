<?php

namespace Database\Factories;

use App\Models\Owner;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'owner_id' => Owner::factory(),
            'series_id' => Series::factory(),
            'name' => $this->faker->company(),
        ];
    }
}
