<?php

use App\Models\Owner;
use Inertia\Testing\AssertableInertia;

use function Pest\Faker\faker;

test('an admin can view the owner index page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.owners.index'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Owners/Index')
        );
});

it('shows the right amount of owners on the owner index page', function () {
    Owner::factory(3)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.owners.index'))
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->has('owners', 3)
        );
});

test('a guest cant view the owner index page', function () {
    $this->get(route('admin.owners.index'))
        ->assertRedirect(route('index'));
});

test('an admin can view the owner create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.owners.create'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Owners/Create')
        );
});

test('a guest cant view the owner create page', function () {
    $this->get(route('admin.owners.create'))
        ->assertRedirect(route('index'));
});

test('an admin can create a new owner', function () {
    $this->actingAs(createAdminUser())
        ->followingRedirects()
        ->post(route('admin.owners.store', [
            'name' => faker()->userName(),
        ]))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Owners/Index')
            ->has('owners', 1)
        );
});

test('a guest cant create a new owner', function () {
    $this->post(route('admin.owners.store'), [
        'name' => faker()->userName()
    ])
        ->assertRedirect(route('index'));

    $this->assertDatabaseCount('owners', 0);
});

test('an admin can view the owner edit page', function () {
    $owner = Owner::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.owners.edit', [$owner]))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Owners/Edit')
            ->has('owner')
        );
});

test('a guest cant view the owner edit page', function () {
    $owner = Owner::factory()->create();

    $this->get(route('admin.owners.edit', [$owner]))
        ->assertRedirect(route('index'));
});

test('an admin can update an existing owner', function () {
    $owner = Owner::factory()->create();
    $name = faker()->userName();

    $this->actingAs(createAdminUser())
        ->put(route('admin.owners.update', [$owner]), [
            'name' => $name,
        ])
        ->assertRedirect(route('admin.owners.index'));

    expect($owner->fresh()->name)->toBe($name);
});

test('a guest cant update an existing owner', function () {
    $owner = Owner::factory()->create();
    $name = $owner->name;

    $this->put(route('admin.owners.update', [$owner]), [
        'name' => faker()->userName(),
    ])
        ->assertRedirect(route('index'));

    expect($owner->fresh()->name)->toBe($name);
});

test('an owner name must be unique', function () {
    $name = faker()->userName();
    Owner::factory()->create(['name' => $name]);

    $this->actingAs(createAdminUser())
        ->post(route('admin.owners.store'), [
            'name' => $name,
        ])
        ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
});

test('an existing owner can be updated and keep the same name', function () {
    $name = faker()->userName();
    $owner = Owner::factory()->create(['name' => $name]);

    $this->actingAs(createAdminUser())
        ->put(route('admin.owners.update', [$owner]), [
            'name' => $name
        ])
        ->assertSessionDoesntHaveErrors(['name']);
});

test('an existing owner name cant be changed to that of another owner', function () {
    $name = faker()->userName();
    Owner::factory()->create(['name' => $name]);
    $owner = Owner::factory()->create(['name' => faker()->userName()]);

    $this->actingAs(createAdminUser())
        ->put(route('admin.owners.update', [$owner]), [
            'name' => $name
        ])
        ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
});
