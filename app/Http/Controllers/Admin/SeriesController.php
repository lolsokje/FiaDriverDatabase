<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Series\SeriesCreateRequest;
use App\Http\Requests\Admin\Series\SeriesUpdateRequest;
use App\Http\Resources\Admin\Series\SeriesIndexResource;
use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SeriesController extends Controller
{
    public function index(): Response
    {
        $series = Series::orderBy('name')->get();

        return Inertia::render('Admin/Series/Index', [
            'series' => SeriesIndexResource::collection($series),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Series/Create');
    }

    public function store(SeriesCreateRequest $request): RedirectResponse
    {
        Series::query()->create($request->validated());

        return to_route('admin.series.index')
            ->with('notice', 'Series created');
    }

    public function edit(Series $series): Response
    {
        return Inertia::render('Admin/Series/Edit', [
            'series' => new SeriesIndexResource($series),
        ]);
    }

    public function update(Series $series, SeriesUpdateRequest $request): RedirectResponse
    {
        $series->update($request->validated());

        return to_route('admin.series.edit', $series)
            ->with('notice', 'Series updated');
    }
}
