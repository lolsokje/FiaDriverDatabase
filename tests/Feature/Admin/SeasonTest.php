<?php

use App\Models\Season;
use App\Models\Series;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

beforeEach(fn () => $this->series = Series::factory()->create());

test('admins can view seasons within a series', function () {
    Season::factory(3)->for($this->series)->create();

    $season = $this->series->seasons()->orderBy('year', 'DESC')->first();

    $this->actingAs(createAdminUser())
        ->get(route('admin.seasons.index', $this->series))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Seasons/Index')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc())
            ->has('seasons', 3, fn (AssertableInertia $prop) => $prop
                ->where('id', $season->id)
                ->etc()));
});

test('unauthorised users can not view seasons within a series', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.seasons.index', $this->series))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can view the season create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.seasons.create', $this->series))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Seasons/Create')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc()));
});

test('unauthorised users can not view the season create page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.seasons.create', $this->series))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can create seasons within a series', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.seasons.store', $this->series), [
            'year' => fake()->year(),
        ])
        ->assertRedirectToRoute('admin.seasons.index', $this->series)
        ->assertSessionHas('success', 'Season created');

    $this->assertCount(1, Season::all());
    $this->assertCount(1, $this->series->seasons);
});

test('unauthorised users can not create seasons', function (?User $user) {
    potentiallyActingAs($user)
        ->post(route('admin.seasons.store', $this->series), [
            'year' => fake()->year(),
        ])
        ->assertRedirectToIndex();

    $this->assertCount(0, Season::all());
})->with('admin.unauthorised');

test('the year must be unique within the selected series when creating a season', function () {
    Season::factory()->for($this->series)->create(['year' => 2023]);

    $this->actingAs(createAdminUser())
        ->from(route('admin.seasons.create', $this->series))
        ->post(route('admin.seasons.store', $this->series), [
            'year' => 2023,
        ])
        ->assertRedirectToRoute('admin.seasons.create', $this->series)
        ->assertSessionHasErrors([
            'year' => 'The year is already used within the selected series.',
        ]);

    $this->assertCount(1, Season::all());
});

test('admins can view the season edit page', function () {
    $season = Season::factory()->for($this->series)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.seasons.edit', [$this->series, $season]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Seasons/Edit')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $this->series->id)
                ->etc())
            ->has('season', fn (AssertableInertia $prop) => $prop
                ->where('id', $season->id)
                ->etc()));
});

test('unauthorised users can not view the season edit page', function (?User $user) {
    $season = Season::factory()->for($this->series)->create();

    potentiallyActingAs($user)
        ->get(route('admin.seasons.edit', [$this->series, $season]))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can update seasons', function () {
    $season = Season::factory()->for($this->series)->create(['year' => 2022]);

    $this->actingAs(createAdminUser())
        ->put(route('admin.seasons.update', [$this->series, $season]), [
            'year' => 2023,
        ])
        ->assertRedirectToRoute('admin.seasons.edit', [$this->series, $season])
        ->assertSessionHas('success', 'Season updated');

    $this->assertEquals(2023, $season->fresh()->year);
});

test('unauthorised users can not update seasons', function (?User $user) {
    $season = Season::factory()->for($this->series)->create(['year' => 2022]);

    potentiallyActingAs($user)
        ->put(route('admin.seasons.update', [$this->series, $season]), [
            'year' => 2023,
        ])
        ->assertRedirectToIndex();

    $this->assertEquals(2022, $season->fresh()->year);
})->with('admin.unauthorised');

test('the year must be unique within a series when updating a season', function () {
    Season::factory()->for($this->series)->create(['year' => 2022]);
    $season = Season::factory()->for($this->series)->create(['year' => 2021]);

    $this->actingAs(createAdminUser())
        ->from(route('admin.seasons.edit', [$this->series, $season]))
        ->put(route('admin.seasons.update', [$this->series, $season]), [
            'year' => 2022,
        ])
        ->assertRedirectToRoute('admin.seasons.edit', [$this->series, $season])
        ->assertSessionHasErrors([
            'year' => 'The year is already used within the selected series.',
        ]);

    $this->assertEquals(2021, $season->fresh()->year);
});

it('ignores the current season when checking year uniqueness when updating a season', function () {
    $season = Season::factory()->for($this->series)->create(['year' => 2023]);

    $this->actingAs(createAdminUser())
        ->from(route('admin.seasons.edit', [$this->series, $season]))
        ->put(route('admin.seasons.update', [$this->series, $season]), [
            'year' => 2023,
        ])
        ->assertRedirectToRoute('admin.seasons.edit', [$this->series, $season])
        ->assertSessionHas('success', 'Season updated');

    $this->assertEquals(2023, $season->fresh()->year);
});
