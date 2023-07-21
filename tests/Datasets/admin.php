<?php

use App\Models\User;

dataset('admin.unauthorised', [
    [fn () => null],
    [fn () => User::factory()->create()],
]);
