<?php

use App\Models\Driver;
use App\Models\Series;
use App\Models\Team;
use Inertia\Testing\AssertableInertia;

use function Pest\Faker\faker;

test('an admin can view the drivers index page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Drivers/Index'),
        );
});

it('shows the right amount of drivers on the teams index page', function () {
    Driver::factory(3)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->has('drivers', 3),
        );
});

test('a guest cant view the drivers index page', function () {
    $this->get(route('admin.drivers.index'))
        ->assertRedirect(route('index'));
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

test('a guest cant view the driver create page', function () {
    $this->get(route('admin.drivers.create'))
        ->assertRedirect(route('index'));
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

    expect(Driver::all()->count())->toBe(1);
    expect(count($teams->first()->drivers))->toBe(1);
});

test('a guest cant create a driver', function () {
    $teams = Team::factory(3)->for(Series::factory()->create())->create();

    $this->post(route('admin.drivers.store'), [
        'team_id' => $teams->first()->id,
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'dob' => fake()->date(),
        'rating' => fake()->numberBetween(1, 100),
    ])
        ->assertRedirect(route('index'));

    expect(Driver::all()->count())->toBe(0);
    expect(count($teams->first()->drivers))->toBe(0);
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
            ->has('driver')
            ->has('series', 2),
        );
});

test('a guest cant view the driver edit page', function () {
    $this->get(route('admin.drivers.edit', [Driver::factory()->create()]))
        ->assertRedirect(route('index'));
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
    expect($driver->team_id)->toBe($teams->last()->id);
    expect($driver->first_name)->toBe($firstName);
    expect($driver->last_name)->toBe($lastName);
    expect($driver->dob->format('Y-m-d'))->toBe($dob);
    expect($driver->rating)->toBe($rating);
});

test('a guest cant update an existing driver', function () {
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
        ->assertRedirect(route('index'));

    $driver = $driver->fresh();
    expect($driver->first_name)->toBe($oldFirstName);
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

test('free agents are shown on the driver index page', function () {
    Driver::factory(10)->create();
    Driver::factory(2)->freeAgent()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.drivers.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Drivers/Index')
            ->has('drivers', 10)
            ->has('freeAgents', 2),
        );
});

test('an admin can view the show team page', function () {
    $team = Team::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.show', [$team]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/View'),
        );
});

test('a guest cant view the team view page', function () {
    $team = Team::factory()->create();

    $this->get(route('admin.teams.show', [$team]))
        ->assertRedirect(route('index'));
});

it('shows all drivers belonging to a team', function () {
    $team = Team::factory()->create();
    Driver::factory(2)->for($team)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.show', [$team]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/View')
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
            ->component('Admin/Teams/View')
            ->has('drivers', 3),
        );
});

test('an admin can delete a driver from a team', function () {
    $team = Team::factory()->create();
    $driver = Driver::factory()->for($team)->create();

    expect(count($team->drivers))->toBeOne();

    $this->actingAs(createAdminUser())
        ->delete(route('admin.teams.driver.delete', [$team, $driver]))
        ->assertRedirect(route('admin.teams.show', [$team]));

    expect($team->fresh()->drivers)->toBeEmpty();
});

test('a guest cant delete a driver from a team', function () {
    $team = Team::factory()->create();
    $driver = Driver::factory()->for($team)->create();

    expect(count($team->drivers))->toBeOne();

    $this->delete(route('admin.teams.driver.delete', [$team, $driver]))
        ->assertRedirect(route('index'));

    expect(count($team->fresh()->drivers))->toBeOne();
});

test('an admin can add drivers to a team', function () {
    $team = Team::factory()->create();
    $driver = Driver::factory()->freeAgent()->create();

    expect(count($team->drivers))->toBe(0);

    $this->actingAs(createAdminUser())
        ->put(route('admin.teams.driver.add', [$team, $driver]))
        ->assertRedirect(route('admin.teams.show', [$team]));

    expect(count($team->fresh()->drivers))->toBeOne();
});

test('a guest cant add drivers to a team', function () {
    $team = Team::factory()->create();
    $driver = Driver::factory()->freeAgent()->create();

    expect(count($team->drivers))->toBe(0);

    $this->put(route('admin.teams.driver.add', [$team, $driver]))
        ->assertRedirect(route('index'));

    expect(count($team->fresh()->drivers))->toBe(0);
});
