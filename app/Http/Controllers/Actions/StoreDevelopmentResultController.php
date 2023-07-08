<?php

namespace App\Http\Controllers\Actions;

use App\Actions\StoreDevelopmentResults;
use App\Http\Requests\RatingUpdateRequest;
use App\Models\DevelopmentRound;
use Illuminate\Http\RedirectResponse;

class StoreDevelopmentResultController
{
    public function __invoke(RatingUpdateRequest $request): RedirectResponse
    {
        $round = DevelopmentRound::query()
            ->create([
                'year' => resolve('general_settings')->year,
            ]);

        (new StoreDevelopmentResults($request, $round))->handle();

        return to_route('admin.development.rounds.show', $round);
    }
}
