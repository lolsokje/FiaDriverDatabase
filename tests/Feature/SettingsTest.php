<?php

use Inertia\Testing\AssertableInertia;

test('an admin can view the settings page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.settings.show'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Admin/Settings/Show')
        );
});

test('a guest cant view the settings page', function () {
    $this->get(route('admin.settings.show'))
        ->assertRedirect(route('index'));
});

test('an admin can update the current year', function () {
    $this->actingAs(createAdminUser())
        ->post(route('admin.settings.store'), [
            'year' => 2015
        ])
        ->assertRedirect(route('admin.settings.show'));

    expect(resolve('general_settings')->year)->toBe(2015);
});

test('a guest cant update the current year', function () {
    $generalSettings = resolve('general_settings');

    $generalSettings->year = 2000;
    $generalSettings->save();

    $this->post(route('admin.settings.store'), [
        'year' => 2015
    ])
        ->assertRedirect(route('index'));

    expect($generalSettings->year)->toBe(2000);
});
