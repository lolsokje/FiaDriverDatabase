<?php

namespace Database\Factories;

use App\Models\AgeRange;
use Illuminate\Database\Eloquent\Factories\Factory;

class DevRangeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $minRating = $this->faker->numberBetween(30, 40);
        $minDev = $this->faker->numberBetween(-2, 4);
        return [
            'age_range_id' => AgeRange::factory(),
            'min_rating' => $minRating,
            'max_rating' => $this->faker->numberBetween($minRating, $minRating + 10),
            'min_dev' => $minDev,
            'max_dev' => $this->faker->numberBetween($minDev, $minDev + 4),
        ];
    }
}
