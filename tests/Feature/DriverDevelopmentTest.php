<?php

use App\Models\AgeRange;
use App\Models\DevelopmentResult;
use App\Models\DevelopmentRound;
use App\Models\DevRange;
use App\Models\Driver;
use Inertia\Testing\AssertableInertia;

test('an admin can view the driver development page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.development.index'))
        ->assertOk();
});

test('a guest cant view the driver development test', function () {
    $this->get(route('admin.development.index'))
        ->assertRedirect(route('index'));
});

test('an admin can create dev ranges', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.development.store'), [
            'ageRanges' => getRanges(),
        ])
        ->assertRedirect(route('admin.development.index'));

    expect(count(AgeRange::all()))->toBe(2);
    expect(count(DevRange::all()))->toBe(6);
});

it('deletes existing ranges before saving new ones', function () {
    $ageRanges = AgeRange::factory(2)->create();
    DevRange::factory(3)->for($ageRanges->first())->create();
    DevRange::factory(3)->for($ageRanges->last())->create();

    $this->actingAs(createAdminUser())
        ->post(route('admin.development.store'), [
            'ageRanges' => getRanges(),
        ])
        ->assertRedirect(route('admin.development.index'));

    expect(count(AgeRange::all()))->toBe(2);
    expect(count(DevRange::all()))->toBe(6);
});

it('shows the right amount of age and dev ranges on the development page', function () {
    $ageRanges = AgeRange::factory(2)->create();
    DevRange::factory(3)->for($ageRanges->first())->create();
    DevRange::factory(4)->for($ageRanges->last())->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.development.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Development/Index')
            ->has('ageRanges', 2)
            ->has('ageRanges.0.ranges', 3)
            ->has('ageRanges.1.ranges', 4),
        );
});

test('an admin can view the development index page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.development.index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page->component('Admin/Development/Index'));
});

test('a guest cant view the development index page', function () {
    $this->get(route('admin.development.index'))
        ->assertRedirect(route('index'));
});

it('shows the right amount of age and dev ranges on the index page', function () {
    $ageRanges = AgeRange::factory(2)->create();
    DevRange::factory(3)->for($ageRanges->first())->create();
    DevRange::factory(4)->for($ageRanges->last())->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.development.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Development/Index')
            ->has('ageRanges', 2)
            ->has('ageRanges.0.ranges', 3)
            ->has('ageRanges.1.ranges', 4),
        );
});

it('stores a development round for the current year', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.development.results.store'), [
            'drivers' => getDevelopmentDrivers(),
        ])
        ->assertRedirectToRoute('admin.development.rounds.show', DevelopmentRound::first());

    $this->assertCount(1, DevelopmentRound::all());
    $this->assertEquals(resolve('general_settings')->year, DevelopmentRound::first()->year);
});

it('stores development results', function () {
    $developmentDrivers = getDevelopmentDrivers();
    $drivers = Driver::all();

    $this->actingAs(createAdminUser())
        ->post(route('admin.development.results.store'), [
            'drivers' => $developmentDrivers,
        ])
        ->assertRedirectToRoute('admin.development.rounds.show', DevelopmentRound::first());

    foreach ($drivers as $driver) {
        $oldRating = $driver->rating;
        $newRating = $oldRating + 2;

        $devResult = DevelopmentResult::where('driver_id', $driver->id)->first();

        $this->assertEquals($oldRating, $devResult->rating);
        $this->assertEquals(2, $devResult->dev);
        $this->assertEquals($newRating, $devResult->new_rating);

        $this->assertEquals($newRating, $driver->fresh()->rating);
    }
});

test('guests can not store development results', function () {
    $this->post(route('admin.development.results.store'), [
        'drivers' => [],
    ])
        ->assertRedirectToRoute('index');
});

function getRanges(): array
{
    return [
        [
            'min_age' => 0,
            'max_age' => 17,
            'ranges' => [
                ['min_rating' => 0, 'max_rating' => 40, 'min_dev' => 0, 'max_dev' => 4],
                ['min_rating' => 41, 'max_rating' => 50, 'min_dev' => -1, 'max_dev' => 3],
                ['min_rating' => 41, 'max_rating' => 50, 'min_dev' => -1, 'max_dev' => 3],
            ],
        ],
        [
            'min_age' => 18,
            'max_age' => 24,
            'ranges' => [
                ['min_rating' => 0, 'max_rating' => 40, 'min_dev' => -1, 'max_dev' => 3],
                ['min_rating' => 41, 'max_rating' => 50, 'min_dev' => -1, 'max_dev' => 2],
                ['min_rating' => 41, 'max_rating' => 50, 'min_dev' => -1, 'max_dev' => 1],
            ],
        ],
    ];
}

function getDevelopmentDrivers(): array
{
    $drivers = Driver::factory(5)->sequence(
        ['rating' => 40],
        ['rating' => 42],
        ['rating' => 44],
        ['rating' => 46],
        ['rating' => 48],
    )->create();

    return $drivers->map(function (Driver $driver) {
        return [
            'id' => $driver->id,
            'rating' => $driver->rating,
            'dev' => 2,
            'new_rating' => $driver->rating + 2,
        ];
    })->toArray();
}
