<?php

use App\Http\Requests\Admin\Series\SeriesCreateRequest;
use App\Models\Series;
use App\Models\User;
use Inertia\Testing\AssertableInertia;

test('admins can view the admin series index page', function () {
    Series::factory(3)->create();

    $series = Series::orderBy('name')->first();

    $this->actingAs(createAdminUser())
        ->get(route('admin.series.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Series/Index')
            ->has('series', 3, fn (AssertableInertia $prop) => $prop
                ->where('id', $series->id)
                ->where('name', $series->name)
                ->where('primary_colour', $series->primary_colour)
                ->where('secondary_colour', $series->secondary_colour)));
});

test('unauthorised users can not view the admin series index page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.series.index'))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can view the admin series create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.series.create'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Series/Create'));
});

test('unauthorised users can not view the admin series create page', function (?User $user) {
    potentiallyActingAs($user)
        ->get(route('admin.series.create'))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can create series', function () {
    SeriesCreateRequest::fake();

    $this->actingAs(createAdminUser())
        ->post(route('admin.series.store'))
        ->assertRedirectToRoute('admin.series.index')
        ->assertSessionHas('notice', 'Series created');

    $this->assertCount(1, Series::all());
});

test('unauthorised users can not create series', function (?User $user) {
    SeriesCreateRequest::fake();

    potentiallyActingAs($user)
        ->post(route('admin.series.store'))
        ->assertRedirectToIndex();

    $this->assertCount(0, Series::all());
})->with('admin.unauthorised');

test('the series name must be unique when creating a series', function () {
    $series = Series::factory()->create(['name' => 'FIA F1']);
    SeriesCreateRequest::fake(['name' => 'FIA F1']);

    $this->actingAs(createAdminUser())
        ->from(route('admin.series.create'))
        ->post(route('admin.series.store'))
        ->assertRedirectToRoute('admin.series.create')
        ->assertSessionHasErrors([
            'name' => 'The name has already been taken.',
        ]);

    $this->assertCount(1, Series::all());
});

test('admins can view the admin series edit page', function () {
    $series = Series::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.series.edit', $series))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Series/Edit')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $series->id)
                ->etc()));
});

test('unauthorised users can not view the admin series edit page', function (?User $user) {
    $series = Series::factory()->create();

    potentiallyActingAs($user)
        ->get(route('admin.series.edit', $series))
        ->assertRedirectToIndex();
})->with('admin.unauthorised');

test('admins can update series', function () {
    $series = Series::factory()->create();

    $this->actingAs(createAdminUser())
        ->put(route('admin.series.update', $series), [
            'name' => 'New',
            'primary_colour' => '#123456',
            'secondary_colour' => '#654321',
        ])
        ->assertRedirectToRoute('admin.series.edit', $series)
        ->assertSessionHas('notice', 'Series updated');

    $series->refresh();

    $this->assertEquals('New', $series->name);
    $this->assertEquals('#123456', $series->primary_colour);
    $this->assertEquals('#654321', $series->secondary_colour);
});

test('unauthorised users can not update series', function (?User $user) {
    $series = Series::factory()->create();
    $name = $series->name;
    $primaryColour = $series->primary_colour;
    $secondaryColour = $series->secondary_colour;

    potentiallyActingAs($user)
        ->put(route('admin.series.update', $series), [
            'name' => 'New',
            'primary_colour' => '#123456',
            'secondary_colour' => '#654321',
        ])
        ->assertRedirectToIndex();

    $series->refresh();

    $this->assertEquals($name, $series->name);
    $this->assertEquals($primaryColour, $series->primary_colour);
    $this->assertEquals($secondaryColour, $series->secondary_colour);
})->with('admin.unauthorised');

test('the name must be unique when updating a series', function () {
    Series::factory()->create(['name' => 'Name']);
    $series = Series::factory()->create(['name' => 'Unique']);

    $this->actingAs(createAdminUser())
        ->from(route('admin.series.edit', $series))
        ->put(route('admin.series.update', $series), [
            'name' => 'Name',
            'primary_colour' => $series->primary_colour,
            'secondary_colour' => $series->secondary_colour,
        ])
        ->assertRedirectToRoute('admin.series.edit', $series)
        ->assertSessionHasErrors([
            'name' => 'The name has already been taken.',
        ]);
});

it('ignores the current series when checking name uniqueness on updates', function () {
    $series = Series::factory()->create(['name' => 'Name']);

    $this->actingAs(createAdminUser())
        ->put(route('admin.series.update', $series), [
            'name' => 'Name',
            'primary_colour' => '#123456',
            'secondary_colour' => $series->secondary_colour,
        ])
        ->assertRedirectToRoute('admin.series.edit', $series)
        ->assertSessionHasNoErrors();

    $this->assertEquals('#123456', $series->fresh()->primary_colour);
});
