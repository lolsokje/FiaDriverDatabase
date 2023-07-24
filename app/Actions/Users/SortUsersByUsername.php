<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Collection;

class SortUsersByUsername
{
    /**
     * @return Collection<User>
     */
    public static function handle(): Collection
    {
        return User::query()
            ->orderBy('username')
            ->get();
    }
}
