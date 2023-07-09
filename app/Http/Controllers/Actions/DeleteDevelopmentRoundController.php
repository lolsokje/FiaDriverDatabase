<?php

namespace App\Http\Controllers\Actions;

use App\Actions\DestroyDevelopmentRound;
use App\Models\DevelopmentRound;

class DeleteDevelopmentRoundController
{
    public function __invoke(DevelopmentRound $round)
    {
        $action = new DestroyDevelopmentRound;

        $subsequentRounds = DevelopmentRound::query()
            ->where('id', '>', $round->id)
            ->get();

        $subsequentRounds->each(fn (DevelopmentRound $round) => $action->handle($round));

        $action->handle($round);

        return to_route('admin.development.index');
    }
}
