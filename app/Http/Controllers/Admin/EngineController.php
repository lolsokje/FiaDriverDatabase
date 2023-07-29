<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ADmin\Engines\EngineCreateRequest;
use App\Http\Resources\Admin\Engines\EngineResource;
use App\Http\Resources\Admin\Series\SeriesIndexResource;
use App\Models\Engine;
use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class EngineController extends Controller
{
    public function index(Series $series): Response
    {
        $engines = $series->engines()->orderBy('name')->get();

        return Inertia::render('Admin/Engines/Index', [
            'series' => new SeriesIndexResource($series),
            'engines' => EngineResource::collection($engines),
        ]);
    }

    public function create(Series $series): Response
    {
        return Inertia::render('Admin/Engines/Create', [
            'series' => new SeriesIndexResource($series),
        ]);
    }

    public function store(Series $series, EngineCreateRequest $request): RedirectResponse
    {
        $series->engines()->create($request->validated());

        return to_route('admin.engines.index', $series)
            ->with('success', 'Engine created');
    }

    public function edit(Series $series, Engine $engine): Response
    {
        return Inertia::render('Admin/Engines/Edit', [
            'series' => new SeriesIndexResource($series),
            'engine' => new EngineResource($engine),
        ]);
    }

    public function update(Series $series, Engine $engine, EngineCreateRequest $request): RedirectResponse
    {
        $engine->update($request->validated());

        return to_route('admin.engines.edit', [$series, $engine])
            ->with('success', 'Engine updated');
    }
}
