<?php

namespace Database\Factories;

use App\Models\DevelopmentRound;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DevelopmentRoundFactory extends Factory
{
    protected $model = DevelopmentRound::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
