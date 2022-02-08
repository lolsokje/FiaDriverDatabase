<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Team;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DeleteDriverFromTeamController extends Controller
{
    public function __invoke(Team $team, Driver $driver): RedirectResponse
    {
        $driver->team()->disassociate()->save();

        return redirect(route('admin.teams.show', [$team]));
    }
}
