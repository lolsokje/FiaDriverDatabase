<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Drivers\DriverCreateRequest;
use App\Http\Requests\Admin\Drivers\DriverUpdateRequest;
use App\Http\Resources\Admin\Drivers\DriverResource;
use App\Http\Resources\UserResource;
use App\Models\Driver;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DriverController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Drivers/Index', [
            'drivers' => DriverResource::collection(Driver::query()->orderBy('last_name')->get()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Drivers/Create');
    }

    public function store(DriverCreateRequest $request): RedirectResponse
    {
        Driver::query()->create($request->validated());

        return to_route('admin.drivers.index')
            ->with('success', 'Driver created');
    }

    public function edit(Driver $driver): Response
    {
        return Inertia::render('Admin/Drivers/Edit', [
            'driver' => new DriverResource($driver),
            'user' => new UserResource($driver->user),
        ]);
    }

    public function update(Driver $driver, DriverUpdateRequest $request): RedirectResponse
    {
        $driver->update($request->validated());

        return to_route('admin.drivers.edit', $driver)
            ->with('success', 'Driver updated');
    }
}
