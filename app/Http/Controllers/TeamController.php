<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
use App\Http\Resources\Admin\Drivers\BaseDriverResource;
use App\Http\Resources\Admin\Owners\BaseOwnerResource;
use App\Http\Resources\Admin\Series\BaseSeriesResource;
use App\Http\Resources\Admin\Teams\DetailedTeamResource;
use App\Models\Driver;
use App\Models\Owner;
use App\Models\Series;
use App\Models\Team;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Response
    {
        $teams = Team::query()->orderBy('name')->with('series', 'owner')->get()->sortBy('series.name');

        return Inertia::render('Admin/Teams/Index', [
            'teams' => DetailedTeamResource::collection($teams->values()->all()),
            'owners' => BaseOwnerResource::collection(Owner::query()->orderBy('name')->get()),
            'series' => BaseSeriesResource::collection(Series::query()->orderBy('name')->get()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Teams/Create', [
            'series' => Series::query()->orderBy('name')->get(),
            'owners' => Owner::query()->orderBy('name')->get(),
        ]);
    }

    public function store(TeamCreateRequest $request): RedirectResponse
    {
        Team::create($request->validated());

        return to_route('admin.teams.index');
    }

    public function show(Team $team): Response
    {
        return Inertia::render('Admin/Teams/Show', [
            'team' => new DetailedTeamResource($team->load('series', 'owner', 'drivers')),
            'drivers' => BaseDriverResource::collection(Driver::freeAgents()->orderBy('last_name')->get()),
        ]);
    }

    public function edit(Team $team): Response
    {
        return Inertia::render('Admin/Teams/Edit', [
            'team' => new DetailedTeamResource($team),
            'series' => BaseSeriesResource::collection(Series::query()->orderBy('name')->get()),
            'owners' => BaseOwnerResource::collection(Owner::query()->orderBy('name')->get()),
        ]);
    }

    public function update(TeamUpdateRequest $request, Team $team): RedirectResponse
    {
        $team->update($request->validated());

        return to_route('admin.teams.index');
    }
}
