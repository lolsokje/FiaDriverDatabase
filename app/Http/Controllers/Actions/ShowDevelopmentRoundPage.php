<?php

namespace App\Http\Controllers\Actions;

use App\Http\Resources\Admin\Development\DevelopmentResultResource;
use App\Http\Resources\Admin\Development\DevelopmentRoundResource;
use App\Models\DevelopmentRound;
use Inertia\Inertia;
use Inertia\Response;

class ShowDevelopmentRoundPage
{
    public function __invoke(DevelopmentRound $round): Response
    {
        $round->load([
            'developmentResults' => [
                'driver',
                'team.series',
            ],
        ]);

        return Inertia::render('Admin/Development/Show', [
            'round' => new DevelopmentRoundResource($round),
            'results' => DevelopmentResultResource::collection($round->developmentResults),
        ]);
    }
}
