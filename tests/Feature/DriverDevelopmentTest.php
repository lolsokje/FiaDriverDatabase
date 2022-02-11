<?php

use App\Models\AgeRange;
use App\Models\DevRange;
use Inertia\Testing\AssertableInertia;

test('an admin can view the driver development page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.development.show'))
        ->assertOk();
});

test('a guest cant view the driver development test', function () {
    $this->get(route('admin.development.show'))
        ->assertRedirect(route('index'));
});

test('an admin can create dev ranges', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.development.store'), [
            'ageRanges' => getRanges(),
        ])
        ->assertRedirect(route('admin.development.show'));

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
        ->assertRedirect(route('admin.development.show'));

    expect(count(AgeRange::all()))->toBe(2);
    expect(count(DevRange::all()))->toBe(6);
});

it('shows the right amount of age and dev ranges on the development page', function () {
    $ageRanges = AgeRange::factory(2)->create();
    DevRange::factory(3)->for($ageRanges->first())->create();
    DevRange::factory(4)->for($ageRanges->last())->create();

    $this->actingAs(createAdminUser())
        ->get(route('admin.development.show'))
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Development/Show')
            ->has('ageRanges', 2)
            ->has('ageRanges.0.ranges', 3)
            ->has('ageRanges.1.ranges', 4)
        );
});

test('an admin can view the development index page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.development.index'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page->component('Admin/Development/Index'));
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
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Development/Index')
            ->has('ageRanges', 2)
            ->has('ageRanges.0.ranges', 3)
            ->has('ageRanges.1.ranges', 4)
        );
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
            ]
        ],
        [
            'min_age' => 18,
            'max_age' => 24,
            'ranges' => [
                ['min_rating' => 0, 'max_rating' => 40, 'min_dev' => -1, 'max_dev' => 3],
                ['min_rating' => 41, 'max_rating' => 50, 'min_dev' => -1, 'max_dev' => 2],
                ['min_rating' => 41, 'max_rating' => 50, 'min_dev' => -1, 'max_dev' => 1],
            ]
        ]
    ];
}
