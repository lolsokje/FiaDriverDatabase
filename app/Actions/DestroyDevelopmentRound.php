<?php

namespace App\Actions;

use App\Models\DevelopmentResult;
use App\Models\DevelopmentRound;

class DestroyDevelopmentRound
{
    public function handle(DevelopmentRound $round): void
    {
        $round->developmentResults()->each(function (DevelopmentResult $result) {
            $result->driver()->update(['rating' => $result->rating]);
            $result->delete();
        });

        $round->delete();
    }
}
