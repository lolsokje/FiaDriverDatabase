<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Seasons\SeasonCreateRequest;
use App\Http\Requests\Admin\Seasons\SeasonUpdateRequest;
use App\Http\Resources\Admin\Seasons\SeasonResource;
use App\Http\Resources\Admin\Series\SeriesIndexResource;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SeasonController extends Controller
{
    public function index(Series $series): Response
    {
        return Inertia::render('Admin/Seasons/Index', [
            'series' => new SeriesIndexResource($series),
            'seasons' => SeasonResource::collection($series->seasons()->orderBy('year', 'DESC')->get()),
        ]);
    }

    public function create(Series $series): Response
    {
        return Inertia::render('Admin/Seasons/Create', [
            'series' => new SeriesIndexResource($series),
        ]);
    }

    public function store(Series $series, SeasonCreateRequest $request): RedirectResponse
    {
        $series->seasons()->create($request->validated());

        return to_route('admin.seasons.index', $series)
            ->with('success', 'Season created');
    }

    public function edit(Series $series, Season $season): Response
    {
        return Inertia::render('Admin/Seasons/Edit', [
            'series' => new SeriesIndexResource($series),
            'season' => new SeasonResource($season),
        ]);
    }

    public function update(Series $series, Season $season, SeasonUpdateRequest $request): RedirectResponse
    {
        $season->update($request->validated());

        return to_route('admin.seasons.edit', [$series, $season])
            ->with('success', 'Season updated');
    }
}
