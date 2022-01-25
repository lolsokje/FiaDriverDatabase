<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesCreateRequest;
use App\Http\Requests\SeriesUpdateRequest;
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
            'series' => Series::all(),
        ]);
    }

    public function show(Series $series): Response
    {
        return Inertia::render('Admin/Series/View', [
            'series' => $series,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Series/Create');
    }

    public function store(SeriesCreateRequest $request): RedirectResponse
    {
        Series::create($request->validated());

        return redirect(route('admin.series.index'));
    }

    public function edit(Series $series): Response
    {
        return Inertia::render('Admin/Series/Edit', [
            'series' => $series,
        ]);
    }

    public function update(SeriesUpdateRequest $request, Series $series): RedirectResponse
    {
        $series->update($request->validated());

        return redirect(route('admin.series.index'));
    }
}
