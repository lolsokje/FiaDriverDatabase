<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesCreateRequest;
use App\Http\Requests\SeriesUpdateRequest;
use App\Http\Resources\Admin\Series\BaseSeriesResource;
use App\Http\Resources\Admin\Series\DetailedSeriesResource;
use App\Models\Series;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Response
    {
        return Inertia::render('Admin/Series/Index', [
            'series' => BaseSeriesResource::collection(Series::all()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Series/Create');
    }

    public function store(SeriesCreateRequest $request): RedirectResponse
    {
        Series::create($request->validated());

        return to_route('admin.series.index');
    }

    public function edit(Series $series): Response
    {
        return Inertia::render('Admin/Series/Edit', [
            'series' => new DetailedSeriesResource($series),
        ]);
    }

    public function update(SeriesUpdateRequest $request, Series $series): RedirectResponse
    {
        $series->update($request->validated());

        return to_route('admin.series.index');
    }
}
