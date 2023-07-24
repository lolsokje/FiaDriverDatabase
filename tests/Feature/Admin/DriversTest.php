<?php

use App\Models\Driver;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('admins can view the admin drivers index page', function () {
    Driver::factory(3)->create();

    $driver = Driver::query()->orderBy('last_name')->first();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Drivers/Index')
            ->has('drivers', 3, fn (AssertableInertia $prop) => $prop
                ->where('id', $driver->id)
                ->etc()));
});

test('unauthorised users can not view the admin driver index page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.drivers.index'))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can view the driver create page', function () {
    User::factory(3)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.create'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Drivers/Create')
            ->has('users', 4));
});

test('unauthorised users can not view the driver create page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.drivers.create'))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can create drivers', function () {
    $user = User::factory()->create();

    $this->actingAs(createAdminUser())
        ->post(route('admin.drivers.store'), [
            'user_id' => $user->id,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dob' => fake()->date(),
        ])
        ->assertRedirectToRoute('admin.drivers.index')
        ->assertSessionHas('success', 'Driver created');

    $this->assertCount(1, Driver::all());
    $this->assertCount(1, $user->drivers);
});

test('unauthorised users can not create drivers', function (?User $user) {
    potentiallyActingAs($user)
        ->post(route('admin.drivers.store'))
        ->assertRedirectToIndex();

    $this->assertCount(0, Driver::all());
})->with('admin.unauthorised');

test('the first and last name combination must be unique when creating a driver', function () {
    $driver = Driver::factory()->create([
        'first_name' => 'First',
        'last_name' => 'Last',
    ]);

    $this->actingAs(createAdminUser())
        ->from(route('admin.drivers.create'))
        ->post(route('admin.drivers.store'), [
            'user_id' => $driver->user->id,
            'first_name' => 'First',
            'last_name' => 'Last',
            'dob' => fake()->date(),
        ])
        ->assertRedirectToRoute('admin.drivers.create')
        ->assertSessionHasErrors([
            'first_name' => 'A driver with this full name already exists.',
        ]);

    $this->assertCount(1, Driver::all());
});

test('admins can view the driver edit page', function () {
    $driver = Driver::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.edit', $driver))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Drivers/Edit')
            ->has('driver', fn (AssertableInertia $prop) => $prop
                ->where('id', $driver->id)
                ->where('user.id', $driver->user_id)
                ->etc()));
});

test('unauthorised users can not view the driver edit page', function (?User $user) {
    $driver = Driver::factory()->create();
    potentiallyActingAs($user)
        ->get(route('admin.drivers.edit', $driver))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can update drivers', function () {
    $driver = Driver::factory()->create();

    $this->actingAs(createAdminUser())
        ->put(route('admin.drivers.update', $driver), [
            'user_id' => $driver->user_id,
            'first_name' => 'First',
            'last_name' => 'Last',
            'dob' => $driver->dob,
        ])
        ->assertRedirectToRoute('admin.drivers.edit', $driver)
        ->assertSessionHas('success', 'Driver updated');

    $driver->refresh();

    $this->assertEquals('First', $driver->first_name);
    $this->assertEquals('Last', $driver->last_name);
});

test('unauthorised users can not update drivers', function (?User $user) {
    $driver = Driver::factory()->create();
    $firstName = $driver->first_name;
    $lastName = $driver->last_name;

    potentiallyActingAs($user)
        ->put(route('admin.drivers.update', $driver), [
            'user_id' => $driver->user->id,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dob' => $driver->dob,
        ])
        ->assertRedirectToIndex();

    $driver->refresh();

    $this->assertEquals($firstName, $driver->first_name);
    $this->assertEquals($lastName, $driver->last_name);
})->with('admin.unauthorised');

test('the first and last name combination must be unique when updating drivers', function () {
    $firstDriver = Driver::factory()->create([
        'first_name' => 'First',
        'last_name' => 'Last',
    ]);

    $driver = Driver::factory()->create();
    $firstName = $driver->first_name;
    $lastName = $driver->last_name;

    $this->actingAs(createAdminUser())
        ->from(route('admin.drivers.edit', $driver))
        ->put(route('admin.drivers.update', $driver), [
            'user_id' => $driver->user->id,
            'first_name' => $firstDriver->first_name,
            'last_name' => $firstDriver->last_name,
            'dob' => $driver->dob,
        ])
        ->assertRedirectToRoute('admin.drivers.edit', $driver)
        ->assertSessionHasErrors([
            'first_name' => 'A driver with this full name already exists.',
        ]);

    $driver->refresh();

    $this->assertEquals($firstName, $driver->first_name);
    $this->assertEquals($lastName, $driver->last_name);
});

it('ignores the current driver when checking first and last name uniqueness', function () {
    $driver = Driver::factory()->create();

    $this->actingAs(createAdminUser())
        ->put(route('admin.drivers.update', $driver), $driver->toArray())
        ->assertRedirectToRoute('admin.drivers.edit', $driver)
        ->assertSessionHasNoErrors();
});
