<?php

use Inertia\Testing\AssertableInertia as Assert;

it('shows the home page', function () {
    $this->get(route('index'))
        ->assertInertia(fn(Assert $page) => $page
            ->component('Index'));
});
