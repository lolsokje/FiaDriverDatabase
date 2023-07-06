<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverCreateRequest;
use App\Http\Resources\Admin\Drivers\DetailedDriverResource;
use App\Http\Resources\Admin\Series\DetailedSeriesResource;
use App\Models\Driver;
use App\Models\Series;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DriverController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Drivers/Index', [
            'drivers' => DetailedDriverResource::collection(Driver::withoutFreeAgents()->sortedBySeries()),
            'freeAgents' => DetailedDriverResource::collection(Driver::freeAgents()->get()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Drivers/Create', [
            'series' => DetailedSeriesResource::collection(Series::with('teams')->get()),
        ]);
    }

    public function store(DriverCreateRequest $request): RedirectResponse
    {
        Driver::create($request->validated());

        return to_route('admin.drivers.index');
    }

    public function show(Driver $driver): Response
    {
        return Inertia::render('Admin/Drivers/View', [
            'driver' => $driver,
        ]);
    }

    public function edit(Driver $driver): Response
    {
        return Inertia::render('Admin/Drivers/Edit', [
            'driver' => new DetailedDriverResource($driver->load('team')),
            'series' => DetailedSeriesResource::collection(Series::with('teams')->get()),
        ]);
    }

    public function update(DriverCreateRequest $request, Driver $driver): RedirectResponse
    {
        $driver->update($request->validated());

        return to_route('admin.drivers.index');
    }
}
