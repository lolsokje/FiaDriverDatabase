<?php

namespace App\Actions;

use App\Http\Requests\RatingUpdateRequest;
use App\Models\DevelopmentRound;
use App\Models\Driver;

class StoreDevelopmentResults
{
    public function __construct(
        private readonly RatingUpdateRequest $request,
        private readonly DevelopmentRound $developmentRound,
    ) {
    }

    public function handle(): void
    {
        foreach ($this->request->drivers() as $driver) {
            $databaseDriver = Driver::query()->with('team.series')->find($driver->id);

            $this->developmentRound->developmentResults()->create([
                'driver_id' => $driver->id,
                'team_id' => $databaseDriver->team_id ?? null,
                'series_id' => $databaseDriver->team?->series_id ?? null,
                'rating' => $driver->rating,
                'dev' => $driver->dev,
                'new_rating' => $driver->newRating,
            ]);

            $databaseDriver->update(['rating' => $driver->newRating]);
        }
    }
}
