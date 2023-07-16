<?php

namespace App\Actions\Drivers;

use App\Models\Driver;
use Illuminate\Support\Collection;

readonly class GetDriversForAdminIndex
{
    public function __construct(
        private SortDriversBySeries $sortDriversBySeries,
    ) {
    }

    public function handle(): Collection
    {
        return Driver::query()
            ->with([
                'team' => ['owner', 'series'],
                'series',
            ])
            ->get()
            ->sort(fn (
                Driver $driverOne,
                Driver $driverTwo,
            ) => $this->sortDriversBySeries->handle($driverOne, $driverTwo));
    }
}
