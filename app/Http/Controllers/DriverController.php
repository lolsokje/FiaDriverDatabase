<?php

namespace App\Http\Controllers;

use App\Actions\Drivers\GetDriversForAdminIndex;
use App\Http\Requests\DriverCreateRequest;
use App\Http\Resources\Admin\Drivers\DetailedDriverResource;
use App\Http\Resources\Admin\Series\BaseSeriesResource;
use App\Http\Resources\Admin\Series\DetailedSeriesResource;
use App\Models\Driver;
use App\Models\Series;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DriverController extends Controller
{
    public function index(GetDriversForAdminIndex $getDriversForAdminIndex): Response
    {
        return Inertia::render('Admin/Drivers/Index', [
            'series' => BaseSeriesResource::collection(Series::orderBy('name')->get()),
            'drivers' => DetailedDriverResource::collection($getDriversForAdminIndex->handle()),
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
