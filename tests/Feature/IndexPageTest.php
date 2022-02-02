<?php

use App\Models\Driver;
use Inertia\Testing\AssertableInertia;

it('shows the index page', function () {
    $this->get(route('index'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Index')
        );
});

it('shows all drivers on the index page', function () {
    Driver::factory(10)->create();
    Driver::factory(5)->freeAgent()->create();

    $this->get(route('index'))
        ->assertOk()
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Index')
            ->has('drivers', 15)
        );
});
