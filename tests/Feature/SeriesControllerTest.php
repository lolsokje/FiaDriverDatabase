<?php

use App\Models\Series;
use Inertia\Testing\AssertableInertia;

test('an admin can view the series index page', function () {
    Series::factory(3)->create();

    $series = Series::first();

    $this->actingAs(createAdminUser())
        ->get(route('admin.series.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Series/Index')
            ->has('series', 3, fn (AssertableInertia $prop) => $prop
                ->where('id', $series->id)
                ->etc()),
        );
});

test('a guest can not view the series index page', function () {
    $this->get(route('admin.series.index'))
        ->assertRedirectToRoute('index');
});

test('an admin can view the series create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.series.create'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Series/Create'),
        );
});

test('a guest can not view the series create page', function () {
    $this->get(route('admin.series.create'))
        ->assertRedirectToRoute('index');
});

test('an admin can create a new series', function () {
    $this->actingAs(createAdminUser())
        ->followingRedirects()
        ->post(route('admin.series.store', ['name' => 'F1']))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Series/Index')
            ->has('series', 1),
        );
});

test('a guest can not create a new series', function () {
    $this->post(route('admin.series.store'), [
        'name' => 'F1',
    ])
        ->assertRedirect(route('index'));

    $this->assertDatabaseCount('series', 0);
});

test('an admin can view the series edit page', function () {
    $series = Series::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.series.edit', [$series]))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Series/Edit')
            ->has('series', fn (AssertableInertia $prop) => $prop
                ->where('id', $series->id)
                ->where('name', $series->name)
                ->etc()),
        );
});

test('a guest can not view the series edit page', function () {
    $series = Series::factory()->create();

    $this->get(route('admin.series.edit', [$series]))
        ->assertRedirect(route('index'));
});

test('an admin can update an existing series', function () {
    $series = Series::factory()->create();

    $this->actingAs(createAdminUser())
        ->put(route('admin.series.update', [$series]), [
            'name' => 'F2',
        ])
        ->assertRedirect(route('admin.series.index'));

    $this->assertEquals('F2', $series->fresh()->name);
});

test('a guest can not update an existing series', function () {
    $series = Series::factory()->create();
    $name = $series->name;

    $this->put(route('admin.series.update', [$series]), [
        'name' => 'F2',
    ])
        ->assertRedirect(route('index'));

    $this->assertEquals($name, $series->fresh()->name);
});

test('a series name must be unique', function () {
    Series::factory()->create(['name' => 'F1']);

    $this->actingAs(createAdminUser())
        ->post(route('admin.series.store'), [
            'name' => 'F1',
        ])
        ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
});

test('series names must be unique', function () {
    Series::factory()->create(['name' => 'F1']);
    $series = Series::factory()->create(['name' => 'F2']);

    $this->actingAs(createAdminUser())
        ->put(route('admin.series.update', [$series]), [
            'name' => 'F1',
        ])
        ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
});

test('it ignores the current series when checking name uniqueness', function () {
    $series = Series::factory()->create(['name' => 'F1']);

    $this->actingAs(createAdminUser())
        ->put(route('admin.series.update', [$series]), [
            'name' => 'F1',
        ])
        ->assertSessionDoesntHaveErrors(['name']);
});
