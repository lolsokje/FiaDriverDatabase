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

        if ($driverOne->series === $driverTwo->series) {
            return $driverOne->driver_id <=> $driverTwo->driver_id;
        }

        return $driverOne->series->name <=> $driverTwo->series->name;
    }
}
