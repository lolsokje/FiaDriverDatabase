<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ShowSettingsPageController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Settings/Show', [
            'year' => resolve('general_settings')->year,
        ]);
    }
}
