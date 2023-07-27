<?php

namespace Database\Factories;

use App\Models\Series;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'series_id' => Series::factory(),
            'user_id' => User::factory(),
            'full_name' => $this->faker->company(),
            'short_name' => $this->faker->word(),
            'primary_colour' => $this->faker->safeHexColor(),
            'secondary_colour' => $this->faker->safeHexColor(),
        ];
    }
}
