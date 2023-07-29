<?php

namespace Database\Factories;

use App\Models\Engine;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class EngineFactory extends Factory
{
    protected $model = Engine::class;

    public function definition(): array
    {
        return [
            'series_id' => Series::factory(),
            'name' => $this->faker->name(),
        ];
    }
}
