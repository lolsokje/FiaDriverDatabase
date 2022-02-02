<?php

namespace App\Http\Controllers;

use App\Http\Requests\DriverCreateRequest;
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
            'drivers' => Driver::withoutFreeAgents()->sortedBySeries(),
            'freeAgents' => Driver::freeAgents()->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Drivers/Create', [
            'series' => Series::with('teams')->get(),
        ]);
    }

    public function store(DriverCreateRequest $request): RedirectResponse
    {
        Driver::create($request->validated());

        return redirect(route('admin.drivers.index'));
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
            'driver' => $driver->load('team'),
            'series' => Series::with('teams')->get(),
        ]);
    }

    public function update(DriverCreateRequest $request, Driver $driver): RedirectResponse
    {
        $driver->update($request->validated());

        return redirect(route('admin.drivers.index'));
    }
}
