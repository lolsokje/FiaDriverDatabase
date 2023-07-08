<?php

namespace Database\Factories;

use App\Models\DevelopmentResult;
use App\Models\DevelopmentRound;
use App\Models\Driver;
use App\Models\Series;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class DevelopmentResultFactory extends Factory
{
    protected $model = DevelopmentResult::class;

    public function definition(): array
    {
        return [
            'development_round_id' => DevelopmentRound::factory(),
            'driver_id' => Driver::factory(),
            'team_id' => Team::factory(),
            'series_id' => Series::factory(),
            'rating' => $this->faker->randomNumber(),
            'dev' => $this->faker->randomNumber(),
            'new_rating' => $this->faker->randomNumber(),
        ];
    }
}
