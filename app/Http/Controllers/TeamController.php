<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamUpdateRequest;
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
            'teams' => $teams->values()->all(),
            'owners' => Owner::query()->orderBy('name')->get(),
            'series' => Series::query()->orderBy('name')->get(),
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

        return redirect(route('admin.teams.index'));
    }

    public function show(Team $team): Response
    {
        return Inertia::render('Admin/Teams/View', [
            'team' => $team->load('series', 'owner')
        ]);
    }

    public function edit(Team $team): Response
    {
        return Inertia::render('Admin/Teams/Edit', [
            'team' => $team,
            'series' => Series::query()->orderBy('name')->get(),
            'owners' => Owner::query()->orderBy('name')->get(),
        ]);
    }

    public function update(TeamUpdateRequest $request, Team $team): RedirectResponse
    {
        $team->update($request->validated());

        return redirect(route('admin.teams.index'));
    }
}
