<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('admins can view the user index page', function () {
    $admin = createAdminUser();
    User::factory(3)->create();

    $user = User::query()->orderBy('username')->first();

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Users/Index')
            ->has('users', 4, fn (AssertableInertia $prop) => $prop
                ->where('id', $user->id)
                ->etc()));
});

test('unauthorised users can not view the user index page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.users.index'))
        ->assertRedirectToRoute('index');
})->with('admin.unauthorised');

test('admins can view the user create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.users.create'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Users/Create'));
});

test('unauthorised can not view the user create page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.users.create'))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can create users', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.users.store'), [
            'username' => fake()->userName(),
            'discord_id' => fake()->numberBetween(),
        ])
        ->assertRedirectToRoute('admin.users.index')
        ->assertSessionHas('notice', 'User created');

    $this->assertCount(2, User::all());
});

test('unauthorised users can not create users', function (?User $user) {
    $userCount = User::count();

    potentiallyActingAs($user)
        ->from(route('admin.users.create'))
        ->post(route('admin.users.store'))
        ->assertRedirectToIndex();

    $this->assertCount($userCount, User::all());
})->with('admin.unauthorised');

test('usernames and discord ids must be unique when creating users', function () {
    $user = User::factory()->create([
        'username' => 'username',
        'discord_id' => '123456',
    ]);

    $this->actingAs(createAdminUser())
        ->post(route('admin.users.store'), [
            'username' => 'username',
            'discord_id' => '123456',
        ])
        ->assertSessionHasErrors([
            'username' => 'The username has already been taken.',
            'discord_id' => 'The discord id has already been taken.',
        ]);

    $this->assertCount(2, User::all());
});

test('admins can view the user edit page', function () {
    $user = User::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.users.edit', $user))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Users/Edit')
            ->has('user', fn (AssertableInertia $prop) => $prop
                ->where('id', $user->id)
                ->etc()));
});

test('unauthorised users can not view the user edit page', function (?User $user) {
    $editUser = User::factory()->create();
    potentiallyActingAs($user)
        ->get(route('admin.users.edit', $editUser))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can update users', function () {
    $user = User::factory()->create();

    $this->actingAs(createAdminUser())
        ->put(route('admin.users.update', $user), [
            'discord_id' => '123456',
            'username' => 'changed',
        ])
        ->assertRedirectToRoute('admin.users.edit', $user)
        ->assertSessionHas('notice', 'User updated');

    $user->refresh();

    $this->assertEquals('123456', $user->discord_id);
    $this->assertEquals('changed', $user->username);
});

test('unauthorised users can not update users', function (?User $user) {
    $updateUser = User::factory()->create();
    $username = $updateUser->username;

    potentiallyActingAs($user)
        ->put(route('admin.users.update', $updateUser))
        ->assertRedirectToIndex();

    $updateUser->refresh();

    $this->assertEquals($username, $updateUser->username);
})->with('admin.unauthorised');

test('usernames and discord ids must be unique when updating users', function () {
    User::factory()->create([
        'username' => 'username',
        'discord_id' => '123456',
    ]);

    $user = User::factory()->create();

    $this->actingAs(createAdminUser())
        ->put(route('admin.users.update', $user), [
            'username' => 'username',
            'discord_id' => '123456',
        ])
        ->assertSessionHasErrors([
            'username' => 'The username has already been taken.',
            'discord_id' => 'The discord id has already been taken.',
        ]);
});

it('ignores the current user when checking username and discord id uniqueness', function () {
    $user = User::factory()->create([
        'username' => 'username',
        'discord_id' => '123456',
    ]);

    $this->actingAs(createAdminUser())
        ->put(route('admin.users.update', $user), [
            'username' => 'username',
            'discord_id' => '123456',
        ])
        ->assertSessionHasNoErrors();
});
