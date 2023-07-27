<?php

use App\Http\Requests\Admin\Teams\TeamCreateRequest;
use App\Models\Series;
use App\Models\Team;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(fn () => $this->series = Series::factory()->create());

test('admins can view the admin teams index page', function () {
    Team::factory(3)->for($this->series)->create();

    $team = $this->series->teams()->orderBy('full_name')->first();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.index', $this->series))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Index')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc())
            ->has('teams', 3, fn (AssertableInertia $prop) => $prop
                ->where('id', $team->id)
                ->etc()));
});

test('unauthorised users can not view the admin teams index page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.teams.index', $this->series))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can view the admin teams create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.create', $this->series))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Create')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc()));
});

test('unauthorised users can not view the admin teams create page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.teams.create', $this->series))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can create teams', function () {
    TeamCreateRequest::fake();

    $this->actingAs(createAdminUser())
        ->post(route('admin.teams.store', $this->series))
        ->assertRedirectToRoute('admin.teams.index', $this->series)
        ->assertSessionHas('success', 'Team created');

    $this->assertCount(1, $this->series->teams()->get());
});

test('unauthorised users can not create teams', function (?User $user) {
    potentiallyActingAs($user)
        ->post(route('admin.teams.store', $this->series))
        ->assertRedirectToIndex();

    $this->assertCount(0, $this->series->teams()->get());
})->with('admin.unauthorised');

test('admins can view the admin teams edit page', function () {
    $team = Team::factory()->for($this->series)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.teams.edit', [$this->series, $team]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Teams/Edit')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc())
            ->has('team', fn (AssertableInertia $prop) => $prop
                ->where('id', $team->id)
                ->etc()));
});

test('unauthorised users can not view the admin teams edit page', function (?User $user) {
    $team = Team::factory()->for($this->series)->create();

    potentiallyActingAs($user)
        ->get(route('admin.teams.edit', [$this->series, $team]))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can update teams', function () {
    $team = Team::factory()->create();

    $data = array_merge(
        $team->toArray(),
        ['full_name' => 'New full name'],
    );

    $this->actingAs(createAdminUser())
        ->put(route('admin.teams.update', [$this->series, $team]), $data)
        ->assertRedirectToRoute('admin.teams.edit', [$this->series, $team])
        ->assertSessionHas('success', 'Team updated');

    $team->refresh();

    $this->assertEquals('New full name', $team->full_name);
});

test('unauthorised users can not update teams', function (?User $user) {
    $team = Team::factory()->for($this->series)->create();
    $name = $team->full_name;

    $data = array_merge(
        $team->toArray(),
        ['full_name' => 'New full name'],
    );

    potentiallyActingAs($user)
        ->put(route('admin.teams.update', [$this->series, $team]), $data)
        ->assertRedirectToIndex();

    $team->refresh();

    $this->assertEquals($name, $team->full_name);
})->with('admin.unauthorised');
