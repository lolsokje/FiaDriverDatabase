<?php

use Inertia\Testing\AssertableInertia;

it('loads the index page', function () {
    $this->get(route('index'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Index'));
});
