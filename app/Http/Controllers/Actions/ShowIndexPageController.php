<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Series;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowIndexPageController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Index', [
            'drivers' => Driver::query()->with('team')->get(),
            'series' => Series::all(),
            'year' => resolve('general_settings')->year,
        ]);
    }
}
