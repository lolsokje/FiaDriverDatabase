<?php

use App\Models\User;

it('can create a user', function () {
    User::factory()->create();

    expect(count(User::all()))->toBe(1);
});
