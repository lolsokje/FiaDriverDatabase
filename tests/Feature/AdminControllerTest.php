<?php

use Inertia\Testing\AssertableInertia;

it('redirects to the drivers index page from the admin index page', function () {
    $this->actingAs(createAdminUser())
        ->get(route('admin.index'))
        ->assertRedirectToRoute('admin.drivers.index');
});

it('renders the admin login page', function () {
    $this->get(route('admin.login'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Admin/Login'));
});
