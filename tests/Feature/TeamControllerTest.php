<?php

use App\Models\Owner;
use App\Models\Series;
use App\Models\Team;
use Inertia\Testing\AssertableInertia;

use function Pest\Faker\faker;

test('an admin can view the teams index page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Index'),
        );
});

it('shows the right amount of teams on the teams index page', function () {
    Team::factory(3)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('teams', 3),
        );
});

test('a guest cant view the teams index page', function () {
    $this->get(route('admin.teams.index'))
        ->assertRedirect(route('index'));
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

test('a guest cant view the team create page', function () {
    $this->get(route('admin.teams.create'))
        ->assertRedirect(route('index'));
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

    expect(Team::all()->count())->toBe(1);
    expect(count($series->teams))->toBe(1);
    expect(count($owner->teams))->toBe(1);
});

test('a guest cant create a team', function () {
    $series = Series::factory()->create();
    $owner = Owner::factory()->create();

    $this->post(route('admin.teams.store'), [
        'series_id' => $series->id,
        'owner_id' => $owner->id,
        'name' => fake()->company(),
    ])
        ->assertRedirect(route('index'));

    expect(Team::all()->count())->toBe(0);
    expect(count($series->teams))->toBe(0);
    expect(count($owner->teams))->toBe(0);
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
            ->has('team'),
        );
});

test('a guest cant view the team edit page', function () {
    $this->get(route('admin.teams.edit', [Team::factory()->create()]))
        ->assertRedirect(route('index'));
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

test('a guest cant update an existing team', function () {
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
        ->assertRedirect(route('index'));

    $team = $team->fresh();
    expect($team->series_id)->toBe($series->first()->id);
    expect($team->owner_id)->toBe($owners->first()->id);
    expect($team->name)->toBe($oldName);
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
