<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserCreateRequest;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => UserResource::collection(User::query()->orderBy('username')->get()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Users/Create');
    }

    public function store(UserCreateRequest $request): RedirectResponse
    {
        User::query()->create($request->validated());

        return to_route('admin.users.index')
            ->with('notice', 'User created');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => new UserResource($user),
        ]);
    }

    public function update(User $user, UserUpdateRequest $request): RedirectResponse
    {
        $user->update($request->validated());

        return to_route('admin.users.edit', $user)
            ->with('notice', 'User updated');
    }
}
