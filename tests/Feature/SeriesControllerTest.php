<?php

use App\Models\Series;
use Inertia\Testing\AssertableInertia;

test('an admin can view the series index page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.series.index'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Series/Index')
        );
});

it('shows the right amount of series on the series index page', function () {
    Series::factory(3)->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.series.index'))
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->has('series', 3)
        );
});

test('a guest cant view the series index page', function () {
    $this->get(route('admin.series.index'))
        ->assertRedirect(route('index'));
});

test('an admin can view the series create page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.series.create'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Series/Create')
        );
});

test('a guest cant view the series create page', function () {
    $this->get(route('admin.series.create'))
        ->assertRedirect(route('index'));
});

test('an admin can create a new series', function () {
    $this->actingAs(createAdminUser())
        ->followingRedirects()
        ->post(route('admin.series.store', [
            'name' => 'F1'
        ]))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Series/Index')
            ->has('series', 1)
        );
});

test('a guest cant create a new series', function () {
    $this->post(route('admin.series.store'), [
        'name' => 'F1'
    ])
        ->assertRedirect(route('index'));

    $this->assertDatabaseCount('series', 0);
});

test('an admin can view the series edit page', function () {
    $series = Series::factory()->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.series.edit', [$series]))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Series/Edit')
            ->has('series')
        );
});

test('a guest cant view the series edit page', function () {
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

    expect($series->fresh()->name)->toBe('F2');
});

test('a guest cant update an existing series', function () {
    $series = Series::factory()->create();
    $name = $series->name;

    $this->put(route('admin.series.update', [$series]), [
        'name' => 'F2',
    ])
        ->assertRedirect(route('index'));

    expect($series->fresh()->name)->toBe($name);
});

test('a series name must be unique', function () {
    Series::factory()->create(['name' => 'F1']);

    $this->actingAs(createAdminUser())
        ->post(route('admin.series.store'), [
            'name' => 'F1',
        ])
        ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
});

test('an existing series can be updated and keep the same name', function () {
    $series = Series::factory()->create(['name' => 'F1']);

    $this->actingAs(createAdminUser())
        ->put(route('admin.series.update', [$series]), [
            'name' => 'F1'
        ])
        ->assertSessionDoesntHaveErrors(['name']);
});

test('an existing series name cant be changed to that of another series', function () {
    Series::factory()->create(['name' => 'F1']);
    $series = Series::factory()->create(['name' => 'F2']);

    $this->actingAs(createAdminUser())
        ->put(route('admin.series.update', [$series]), [
            'name' => 'F1'
        ])
        ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
});
