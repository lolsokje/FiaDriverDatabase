<?php

namespace App\Actions\Drivers;

use App\Models\Driver;

class SortBySeriesAndTeamName
{
    public function handle(Driver $driverOne, Driver $driverTwo): int
    {
        if (! $driverOne->team && $driverTwo->team) {
            return 1;
        }

        if (! $driverTwo->team && $driverOne->team) {
            return -1;
        }

        if (! $driverOne->team && ! $driverTwo->team) {
            return $driverOne->last_name <=> $driverTwo->last_name;
        }

        if ($driverOne->series?->id === $driverTwo->series?->id) {
            return $driverOne->team?->name <=> $driverTwo->team?->name;
        }

        return $driverOne->series->name <=> $driverTwo->series->name;
    }
}
