<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerCreateRequest;
use App\Http\Requests\OwnerUpdateRequest;
use App\Http\Resources\Admin\Owners\BaseOwnerResource;
use App\Models\Owner;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Response
    {
        return Inertia::render('Admin/Owners/Index', [
            'owners' => BaseOwnerResource::collection(Owner::query()->orderBy('name')->get()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Owners/Create');
    }

    public function store(OwnerCreateRequest $request): RedirectResponse
    {
        Owner::create($request->validated());

        return to_route('admin.owners.index');
    }

    public function edit(Owner $owner): Response
    {
        return Inertia::render('Admin/Owners/Edit', [
            'owner' => new BaseOwnerResource($owner),
        ]);
    }

    public function update(OwnerUpdateRequest $request, Owner $owner): RedirectResponse
    {
        $owner->update($request->validated());

        return to_route('admin.owners.index');
    }
}
