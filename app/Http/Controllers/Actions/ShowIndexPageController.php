<?php

namespace App\Http\Controllers\Actions;

use App\Actions\Drivers\SortBySeriesAndTeamName;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Drivers\DetailedDriverResource;
use App\Http\Resources\Admin\Series\BaseSeriesResource;
use App\Models\Driver;
use App\Models\Series;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowIndexPageController extends Controller
{
    public function __invoke(Request $request, SortBySeriesAndTeamName $sortBySeriesAndTeamName): Response
    {
        $drivers = Driver::query()
            ->with([
                'team' => ['owner'],
                'series',
            ])
            ->get()
            ->sort(fn (
                Driver $driverOne,
                Driver $driverTwo,
            ) => $sortBySeriesAndTeamName->handle($driverOne, $driverTwo));

        return Inertia::render('Index', [
            'drivers' => DetailedDriverResource::collection($drivers),
            'series' => BaseSeriesResource::collection(Series::all()),
            'year' => resolve('general_settings')->year,
        ]);
    }
}
