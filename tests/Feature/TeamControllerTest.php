<?php

use App\Models\Driver;
use App\Models\Owner;
use App\Models\Series;
use App\Models\Team;
use Inertia\Testing\AssertableInertia;

test('an admin can view the teams index page', function () {
    $series = Series::factory()->create();
    Team::factory(3)->for($series)->create();

    $team = Team::query()->orderBy('name')->first();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Index')
            ->has('teams', 3, fn (AssertableInertia $prop) => $prop
                ->where('id', $team->id)
                ->etc()),
        );
});

test('a guest can not view the teams index page', function () {
    $this->get(route('admin.teams.index'))
        ->assertRedirectToRoute('index');
});

test('an admin can view the team create page', function () {
    Series::factory(3)->create();
    Owner::factory(5)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.create'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Create')
            ->has('series', 3)
            ->has('owners', 5),
        );
});

test('a guest can not view the team create page', function () {
    $this->get(route('admin.teams.create'))
        ->assertRedirectToRoute('index');
});

test('an admin can create a team', function () {
    $series = Series::factory()->create();
    $owner = Owner::factory()->create();

    $this->actingAs(createAdminUser())
        ->post(route('admin.teams.store'), [
            'series_id' => $series->id,
            'owner_id' => $owner->id,
            'name' => fake()->company(),
        ])
        ->assertRedirect(route('admin.teams.index'));

    $this->assertCount(1, Team::all());
    $this->assertCount(1, $series->teams);
    $this->assertCount(1, $owner->teams);
});

test('a guest can not create a team', function () {
    $series = Series::factory()->create();
    $owner = Owner::factory()->create();

    $this->post(route('admin.teams.store'), [
        'series_id' => $series->id,
        'owner_id' => $owner->id,
        'name' => fake()->company(),
    ])
        ->assertRedirectToRoute('index');

    $this->assertCount(0, Team::all());
    $this->assertCount(0, $series->teams);
    $this->assertCount(0, $owner->teams);
});

test('an admin can view the team details page', function () {
    $team = Team::factory()->create();
    [$firstDriver, $secondDriver] = Driver::factory(2)->for($team)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.show', $team))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Show')
            ->has('team', fn (AssertableInertia $prop) => $prop
                ->where('drivers.0.id', $firstDriver->id)
                ->where('drivers.1.id', $secondDriver->id)
                ->etc()));
});

test('guests can not view the team details page', function () {
    $team = Team::factory()->create();

    $this->get(route('admin.teams.show', $team))
        ->assertRedirectToRoute('index');
});

test('an admin can view the team edit page', function () {
    Series::factory(3)->create();
    Owner::factory(5)->create();
    $team = Team::factory()
        ->for(Series::first())
        ->for(Owner::first())
        ->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.edit', [$team]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Edit')
            ->has('series', 3)
            ->has('owners', 5)
            ->has('team', fn (AssertableInertia $prop) => $prop
                ->where('id', $team->id)
                ->etc()),
        );
});

test('a guest can not view the team edit page', function () {
    $this->get(route('admin.teams.edit', [Team::factory()->create()]))
        ->assertRedirectToRoute('index');
});

test('an admin can update an existing team', function () {
    $series = Series::factory(3)->create();
    $owners = Owner::factory(5)->create();

    $team = Team::factory()
        ->for($series->first())
        ->for($owners->first())
        ->create();

    $name = fake()->company();
    $this->actingAs(createAdminUser())
        ->put(route('admin.teams.update', [$team]), [
            'series_id' => $series->last()->id,
            'owner_id' => $owners->last()->id,
            'name' => $name,
        ])
        ->assertRedirect(route('admin.teams.index'));

    $team = $team->fresh();
    expect($team->series_id)->toBe($series->last()->id);
    expect($team->owner_id)->toBe($owners->last()->id);
    expect($team->name)->toBe($name);
});

test('a guest can not update an existing team', function () {
    $series = Series::factory(3)->create();
    $owners = Owner::factory(5)->create();

    $team = Team::factory()
        ->for($series->first())
        ->for($owners->first())
        ->create();

    $oldName = $team->name;
    $newName = fake()->company();

    $this->put(route('admin.teams.update', [$team]), [
        'series_id' => $series->last()->id,
        'owner_id' => $owners->last()->id,
        'name' => $newName,
    ])
        ->assertRedirectToRoute('index');

    $team = $team->fresh();
    $this->assertEquals($series->first()->id, $team->series_id);
    $this->assertEquals($owners->first()->id, $team->owner_id);
    $this->assertEquals($oldName, $team->name);
});

test('the provided series must exist', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.teams.store'), [
            'series_id' => 1,
            'owner_id' => Owner::factory()->create()->id,
            'name' => fake()->company(),
        ])
        ->assertSessionHasErrors(['series_id' => 'The selected series id is invalid.']);
});

test('the provided owner must exist', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.teams.store'), [
            'series_id' => Series::factory()->create()->id,
            'owner_id' => 1,
            'name' => fake()->company(),
        ])
        ->assertSessionHasErrors(['owner_id' => 'The selected owner id is invalid.']);
});
