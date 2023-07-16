<?php

use App\Models\Driver;
use App\Models\Series;
use App\Models\Team;
use Inertia\Testing\AssertableInertia;

test('an admin can view the drivers index page', function () {
    $team = Team::factory()->create();
    Driver::factory(3)->for($team)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Drivers/Index')
            ->has('drivers', 3, fn (AssertableInertia $prop) => $prop
                ->where('team_id', $team->id)
                ->etc()));
});

test('a guest can not view the drivers index page', function () {
    $this->get(route('admin.drivers.index'))
        ->assertRedirectToRoute('index');
});

test('an admin can view the driver create page', function () {
    [$seriesOne, $seriesTwo] = Series::factory(2)->create();

    Team::factory(8)->for($seriesOne)->create();
    Team::factory(5)->for($seriesTwo)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.create'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Drivers/Create')
            ->has('series', 2)
            ->has('series.0.teams', 8)
            ->has('series.1.teams', 5),
        );
});

test('a guest can not view the driver create page', function () {
    $this->get(route('admin.drivers.create'))
        ->assertRedirectToRoute('index');
});

test('an admin can create a driver', function () {
    $teams = Team::factory(3)->for(Series::factory()->create())->create();

    $this->actingAs(createAdminUser())
        ->post(route('admin.drivers.store'), [
            'team_id' => $teams->first()->id,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dob' => fake()->date(),
            'rating' => fake()->numberBetween(1, 100),
        ])
        ->assertRedirect(route('admin.drivers.index'));

    $this->assertCount(1, Driver::all());
    $this->assertCount(1, $teams->first()->drivers);
});

test('a guest can not create a driver', function () {
    $teams = Team::factory(3)->for(Series::factory()->create())->create();

    $this->post(route('admin.drivers.store'), [
        'team_id' => $teams->first()->id,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'dob' => fake()->date(),
        'rating' => fake()->numberBetween(1, 100),
    ])
        ->assertRedirectToRoute('index');

    $this->assertCount(0, Driver::all());
    $this->assertCount(0, $teams->first()->drivers);
});

test('an admin can view the driver edit page', function () {
    Series::factory(2)->create();
    Team::factory(5)->for(Series::first())->create();
    $driver = Driver::factory()->for(Team::first())->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.edit', [$driver]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Drivers/Edit')
            ->has('driver', fn (AssertableInertia $prop) => $prop
                ->where('id', $driver->id)
                ->etc())
            ->has('series', 2),
        );
});

test('a guest can not view the driver edit page', function () {
    $this->get(route('admin.drivers.edit', [Driver::factory()->create()]))
        ->assertRedirectToRoute('index');
});

test('an admin can update an existing driver', function () {
    $series = Series::factory(3)->create();
    $teams = Team::factory(10)->for($series->first())->create();

    $driver = Driver::factory()
        ->for($teams->first())
        ->create();

    $firstName = fake()->firstName();
    $lastName = fake()->lastName();
    $dob = fake()->date();
    $rating = fake()->numberBetween(1, 100);
    $this->actingAs(createAdminUser())
        ->put(route('admin.drivers.update', [$driver]), [
            'team_id' => $teams->last()->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'dob' => $dob,
            'rating' => $rating,
        ])
        ->assertRedirect(route('admin.drivers.index'));

    $driver = $driver->fresh();
    $this->assertEquals($driver->team_id, $teams->last()->id);
    $this->assertEquals($driver->first_name, $firstName);
    $this->assertEquals($driver->last_name, $lastName);
    $this->assertEquals($driver->dob->format('Y-m-d'), $dob);
    $this->assertEquals($driver->rating, $rating);
});

test('a guest can not update an existing driver', function () {
    $series = Series::factory(3)->create();
    $teams = Team::factory(10)->for($series->first())->create();

    $driver = Driver::factory()
        ->for($teams->first())
        ->create();

    $oldFirstName = $driver->first_name;

    $this->put(route('admin.drivers.update', [$driver]), [
        'team_id' => $driver->team_id,
        'first_name' => fake()->firstName(),
        'last_name' => $driver->last_name,
        'dob' => $driver->dob,
        'rating' => $driver->rating,
    ])
        ->assertRedirectToRoute('index');

    $driver = $driver->fresh();
    $this->assertEquals($driver->first_name, $oldFirstName);
});

test('the provided team must exist', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.drivers.store'), [
            'team_id' => 1,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dob' => fake()->date(),
            'rating' => fake()->numberBetween(1, 100),
        ])
        ->assertSessionHasErrors(['team_id' => 'The selected team id is invalid.']);
});

test('a full name must be provided', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.drivers.store'), [
            'team_id' => Team::factory()->create()->id,
            'dob' => fake()->date(),
            'rating' => fake()->numberBetween(1, 100),
        ])
        ->assertSessionHasErrors([
            'first_name' => 'The first name field is required.',
            'last_name' => 'The last name field is required.',
        ]);
});

test('the rating must be a positive integer', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.drivers.store'), [
            'team_id' => Team::factory()->create()->id,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dob' => fake()->date(),
            'rating' => -1,
        ])
        ->assertSessionHasErrors(['rating' => 'The rating must be at least 0.']);

    $this->actingAs(createAdminUser())
        ->post(route('admin.drivers.store'), [
            'team_id' => Team::factory()->create()->id,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dob' => fake()->date(),
            'rating' => 'text',
        ])
        ->assertSessionHasErrors(['rating' => 'The rating must be an integer.']);
});

test('the driver can be a free agent', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.drivers.store'), [
            'team_id' => '',
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'dob' => fake()->date(),
            'rating' => fake()->numberBetween(1, 100),
        ])
        ->assertRedirect(route('admin.drivers.index'))
        ->assertSessionHasNoErrors();
});

test('an admin can view the show team page', function () {
    $team = Team::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.show', [$team]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Show'),
        );
});

test('a guest can not view the team view page', function () {
    $team = Team::factory()->create();

    $this->get(route('admin.teams.show', [$team]))
        ->assertRedirectToRoute('index');
});

it('shows all drivers belonging to a team', function () {
    $team = Team::factory()->create();
    Driver::factory(2)->for($team)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.show', [$team]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Show')
            ->has('team.drivers', 2),
        );
});

it('only shows free agents on the team show page as selectable drivers', function () {
    Driver::factory(10)->create();
    Driver::factory(3)->freeAgent()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.show', [Driver::first()->team]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Show')
            ->has('drivers', 3),
        );
});

test('an admin can delete a driver from a team', function () {
    $team = Team::factory()->create();
    $driver = Driver::factory()->for($team)->create();

    $this->assertCount(1, $team->drivers);

    $this->actingAs(createAdminUser())
        ->put(route('admin.teams.drivers.update', $team), [
            'drivers' => [[]],
        ])
        ->assertRedirect(route('admin.teams.show', [$team]));

    $this->assertCount(0, $team->fresh()->drivers);
});

test('a guest can not delete a driver from a team', function () {
    $team = Team::factory()->create();
    Driver::factory()->for($team)->create();

    $this->assertCount(1, $team->drivers);

    $this->put(route('admin.teams.drivers.update', $team), [
        'drivers' => [[]],
    ])
        ->assertRedirectToRoute('index');

    $this->assertCount(1, $team->fresh()->drivers);
});

test('an admin can add drivers to a team', function () {
    $team = Team::factory()->create();
    $driver = Driver::factory()->freeAgent()->create();

    $this->assertCount(0, $team->drivers);

    $this->actingAs(createAdminUser())
        ->put(route('admin.teams.drivers.update', $team), [
            'drivers' => [['id' => $driver->id, 'rating' => 40, 'driver_id' => 'A1']],
        ])
        ->assertRedirectToRoute('admin.teams.show', $team);

    $this->assertCount(1, $team->fresh()->drivers);
});

test('a guest can not add drivers to a team', function () {
    $team = Team::factory()->create();
    $driver = Driver::factory()->freeAgent()->create();

    $this->assertCount(0, $team->drivers);

    $this->put(route('admin.teams.drivers.update', $team), [
        'drivers' => [['id' => $driver->id, 'rating' => 40, 'driver_id' => 'A1']],
    ])
        ->assertRedirectToRoute('index');

    $this->assertCount(0, $team->fresh()->drivers);
});
