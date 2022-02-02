<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\AgeRange;
use Inertia\Inertia;
use Inertia\Response;

class ShowDevelopmentPageController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Development/Show', [
            'ageRanges' => AgeRange::query()->with('ranges')->get(),
        ]);
    }
}
