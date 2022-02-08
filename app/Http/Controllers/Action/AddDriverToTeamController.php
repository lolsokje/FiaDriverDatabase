<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;

class AddDriverToTeamController extends Controller
{
    public function __invoke(Team $team, Driver $driver): RedirectResponse
    {
        $driver->team()->associate($team)->save();

        return redirect(route('admin.teams.show', [$team]));
    }
}
