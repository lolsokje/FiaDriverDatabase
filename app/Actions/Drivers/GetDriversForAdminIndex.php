<?php

namespace App\Actions\Drivers;

use App\Models\Driver;
use Illuminate\Support\Collection;

readonly class GetDriversForAdminIndex
{
    public function __construct(
        private SortBySeriesAndFullId $sortDriversBySeries,
    ) {
    }

    public function handle(): Collection
    {
        return Driver::query()
            ->with([
                'team' => ['owner'],
                'series',
            ])
            ->get()
            ->sort(fn (
                Driver $driverOne,
                Driver $driverTwo,
            ) => $this->sortDriversBySeries->handle($driverOne, $driverTwo));
    }
}
