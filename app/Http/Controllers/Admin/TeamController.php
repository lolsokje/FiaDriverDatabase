<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Teams\TeamCreateRequest;
use App\Http\Resources\Admin\Series\SeriesIndexResource;
use App\Http\Resources\Admin\Teams\TeamResource;
use App\Models\Series;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function index(Series $series): Response
    {
        $teams = $series->teams()->orderBy('full_name')->get();

        return Inertia::render('Admin/Teams/Index', [
            'series' => new SeriesIndexResource($series),
            'teams' => TeamResource::collection($teams),
        ]);
    }

    public function create(Series $series): Response
    {
        return Inertia::render('Admin/Teams/Create', [
            'series' => new SeriesIndexResource($series),
        ]);
    }

    public function store(Series $series, TeamCreateRequest $request): RedirectResponse
    {
        $series->teams()->create($request->validated());

        return to_route('admin.teams.index', $series)
            ->with('success', 'Team created');
    }

    public function edit(Series $series, Team $team): Response
    {
        return Inertia::render('Admin/Teams/Edit', [
            'series' => new SeriesIndexResource($series),
            'team' => new TeamResource($team),
        ]);
    }

    public function update(Series $series, Team $team, TeamCreateRequest $request): RedirectResponse
    {
        $team->update($request->validated());

        return to_route('admin.teams.edit', [$series, $team])
            ->with('success', 'Team updated');
    }
}
