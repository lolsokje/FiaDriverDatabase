<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Development\DevelopmentRoundResource;
use App\Http\Resources\Admin\Drivers\DetailedDriverResource;
use App\Models\AgeRange;
use App\Models\DevelopmentRound;
use App\Models\Driver;
use Inertia\Inertia;
use Inertia\Response;

class DevelopmentIndexPageController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Development/Index', [
            'drivers' => DetailedDriverResource::collection(Driver::sortedBySeries()),
            'ageRanges' => AgeRange::with('ranges')->get(),
            'developmentRounds' => DevelopmentRoundResource::collection(DevelopmentRound::query()->latest()->get()),
        ]);
    }
}
