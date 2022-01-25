<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerCreateRequest;
use App\Http\Requests\OwnerUpdateRequest;
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
            'owners' => Owner::all(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Owners/Create');
    }

    public function store(OwnerCreateRequest $request): RedirectResponse
    {
        Owner::create($request->validated());

        return redirect(route('admin.owners.index'));
    }

    public function show(Owner $owner): Response
    {
        return Inertia::render('Admin/Series/View', [
            'owner' => $owner,
        ]);
    }

    public function edit(Owner $owner): Response
    {
        return Inertia::render('Admin/Owners/Edit', [
            'owner' => $owner,
        ]);
    }

    public function update(OwnerUpdateRequest $request, Owner $owner): RedirectResponse
    {
        $owner->update($request->validated());

        return redirect(route('admin.owners.index'));
    }
}
