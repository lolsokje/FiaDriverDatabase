<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateTeamDriversRequest;
use App\Models\Driver;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;

class UpdateTeamDriversController extends Controller
{
    public function __invoke(UpdateTeamDriversRequest $request, Team $team): RedirectResponse
    {
        $team->drivers->each(fn (Driver $driver) => $driver->team()->disassociate()->save());

        if (! $request->validated('drivers')) {
            return to_route('admin.teams.show', $team);
        }

        foreach ($request->validated('drivers') as $driver) {
            $databaseDriver = Driver::find($driver['id']);
            $databaseDriver->update([
                'team_id' => $team->id,
                'rating' => $driver['rating'],
                'driver_id' => $driver['driver_id'],
            ]);
        }

        return to_route('admin.teams.show', $team);
    }
}
