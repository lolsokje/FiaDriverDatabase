<?php

namespace App\Actions\Drivers;

use App\Models\Driver;

class SortDriversBySeries
{
    public function handle(Driver $driverOne, Driver $driverTwo): int
    {
        if (! $driverOne->series && $driverTwo->series) {
            return 1;
        }

        if (! $driverTwo->series && $driverOne->series) {
            return -1;
        }

        if ($driverOne->series?->id === $driverTwo->series?->id) {
            return $driverOne->full_id <=> $driverTwo->full_id;
        }

        return $driverOne->series->name <=> $driverTwo->series->name;
    }
}
