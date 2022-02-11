<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\AgeRange;
use Inertia\Inertia;
use Inertia\Response;

class DevelopmentIndexPageController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Development/Index', [
            'ageRanges' => AgeRange::with('ranges')->get(),
        ]);
    }
}
