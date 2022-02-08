<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateDriverRatingRequest;
use App\Models\Driver;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UpdateDriverRatingController extends Controller
{
    public function __invoke(UpdateDriverRatingRequest $request): RedirectResponse
    {
        $drivers = collect($request->validated()['drivers']);

        $drivers->each(function (array $driver) {
            Driver::findOrFail($driver['id'])->update(['rating' => $driver['rating']]);
        });

        return redirect()->back();
    }
}
