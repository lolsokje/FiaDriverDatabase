<?php

use App\Actions\Users\SortUsersByUsername;
use App\Models\User;

it('sorts users by username', function () {
    [$c, $a, $d, $b] = User::factory(4)->sequence(
        ['username' => 'c'],
        ['username' => 'a'],
        ['username' => 'd'],
        ['username' => 'b'],
    )->create();

    $users = SortUsersByUsername::handle();

    $this->assertEquals($a->id, $users[0]->id);
    $this->assertEquals($b->id, $users[1]->id);
    $this->assertEquals($c->id, $users[2]->id);
    $this->assertEquals($d->id, $users[3]->id);
});
