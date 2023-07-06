<?php

use App\Models\Owner;
use Inertia\Testing\AssertableInertia;

use function Pest\Faker\faker;

test('an admin can view the owner index page', function () {
    Owner::factory(3)->create();

    $owner = Owner::query()->orderBy('name')->first();

    $this->actingAs(createAdminUser())
        ->get(route('admin.owners.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Owners/Index')
            ->has('owners', 3, fn (AssertableInertia $prop) => $prop
                ->where('id', $owner->id)
                ->where('name', $owner->name)
                ->etc()),
        );
});

test('a guest can not view the owner index page', function () {
    $this->get(route('admin.owners.index'))
        ->assertRedirectToRoute('index');
});

test('an admin can view the owner create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.owners.create'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Owners/Create'),
        );
});

test('a guest can not view the owner create page', function () {
    $this->get(route('admin.owners.create'))
        ->assertRedirectToRoute('index');
});

test('an admin can create a new owner', function () {
    $this->actingAs(createAdminUser())
        ->followingRedirects()
        ->post(route('admin.owners.store', ['name' => fake()->userName()]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Owners/Index')
            ->has('owners', 1),
        );
});

test('a guest can not create a new owner', function () {
    $this->post(route('admin.owners.store'), [
        'name' => fake()->userName(),
    ])
        ->assertRedirectToRoute('index');

    $this->assertDatabaseCount('owners', 0);
});

test('an admin can view the owner edit page', function () {
    $owner = Owner::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.owners.edit', [$owner]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Owners/Edit')
            ->has('owner', fn (AssertableInertia $prop) => $prop
                ->where('id', $owner->id)
                ->where('name', $owner->name)
                ->etc()),
        );
});

test('a guest can not view the owner edit page', function () {
    $owner = Owner::factory()->create();

    $this->get(route('admin.owners.edit', [$owner]))
        ->assertRedirectToRoute('index');
});

test('an admin can update an existing owner', function () {
    $owner = Owner::factory()->create();
    $name = fake()->userName();

    $this->actingAs(createAdminUser())
        ->put(route('admin.owners.update', [$owner]), [
            'name' => $name,
        ])
        ->assertRedirect(route('admin.owners.index'));

    $this->assertEquals($name, $owner->fresh()->name);
});

test('a guest can not update an existing owner', function () {
    $owner = Owner::factory()->create();
    $name = $owner->name;

    $this->put(route('admin.owners.update', [$owner]), [
        'name' => fake()->userName(),
    ])
        ->assertRedirectToRoute('index');

    $this->assertEquals($name, $owner->fresh()->name);
});

test('an owner name must be unique', function () {
    $name = fake()->userName();
    Owner::factory()->create(['name' => $name]);

    $this->actingAs(createAdminUser())
        ->post(route('admin.owners.store'), [
            'name' => $name,
        ])
        ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
});

it('ignores the current owner when checking name uniqueness', function () {
    $name = fake()->userName();
    $owner = Owner::factory()->create(['name' => $name]);

    $this->actingAs(createAdminUser())
        ->put(route('admin.owners.update', [$owner]), [
            'name' => $name,
        ])
        ->assertSessionDoesntHaveErrors(['name']);
});

test('owner names must be unique when updating an owner', function () {
    $name = fake()->userName();
    Owner::factory()->create(['name' => $name]);
    $owner = Owner::factory()->create(['name' => fake()->userName()]);

    $this->actingAs(createAdminUser())
        ->put(route('admin.owners.update', [$owner]), [
            'name' => $name,
        ])
        ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
});
