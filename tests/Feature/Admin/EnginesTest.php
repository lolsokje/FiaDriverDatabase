<?php

use App\Models\Engine;
use App\Models\Series;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(fn () => $this->series = Series::factory()->create());

test('admins can view the admin engines index page', function () {
    Engine::factory(3)->for($this->series)->create();

    $engine = $this->series->engines()->orderBy('name')->first();

    $this->actingAs(createAdminUser())
        ->get(route('admin.engines.index', $this->series))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Engines/Index')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc())
            ->has('engines', 3, fn (AssertableInertia $prop) => $prop
                ->where('id', $engine->id)
                ->etc()));
});

test('unauthorised users can not view the admin engines index page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.engines.index', $this->series))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can view the admin engines create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.engines.create', $this->series))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Engines/Create')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc()));
});

test('unauthorised users can not view the admin engines create page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.engines.create', $this->series))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can create engines', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.engines.store', $this->series), [
            'name' => fake()->name(),
        ])
        ->assertRedirectToRoute('admin.engines.index', $this->series)
        ->assertSessionHas('success', 'Engine created');

    $this->assertCount(1, $this->series->engines()->get());
});

test('unauthorised users can not create engines', function (?User $user) {
    potentiallyActingAs($user)
        ->post(route('admin.engines.store', $this->series))
        ->assertRedirectToIndex();

    $this->assertCount(0, $this->series->engines()->get());
})->with('admin.unauthorised');

test('admins can view the admin engines edit page', function () {
    $engine = Engine::factory()->for($this->series)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.engines.edit', [$this->series, $engine]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Engines/Edit')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc())
            ->has('engine', fn (AssertableInertia $prop) => $prop
                ->where('id', $engine->id)
                ->etc()));
});

test('unauthorised users can not view the admin engines edit page', function (?User $user) {
    $engine = Engine::factory()->for($this->series)->create();

    potentiallyActingAs($user)
        ->get(route('admin.engines.edit', [$this->series, $engine]))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can update engines', function () {
    $engine = Engine::factory()->create();

    $data = array_merge(
        $engine->toArray(),
        ['name' => 'New name'],
    );

    $this->actingAs(createAdminUser())
        ->put(route('admin.engines.update', [$this->series, $engine]), $data)
        ->assertRedirectToRoute('admin.engines.edit', [$this->series, $engine])
        ->assertSessionHas('success', 'Engine updated');

    $engine->refresh();

    $this->assertEquals('New name', $engine->name);
});

test('unauthorised users can not update engines', function (?User $user) {
    $engine = Engine::factory()->for($this->series)->create();
    $name = $engine->name;

    $data = array_merge(
        $engine->toArray(),
        ['name' => 'New name'],
    );

    potentiallyActingAs($user)
        ->put(route('admin.engines.update', [$this->series, $engine]), $data)
        ->assertRedirectToIndex();

    $engine->refresh();

    $this->assertEquals($name, $engine->name);
})->with('admin.unauthorised');
