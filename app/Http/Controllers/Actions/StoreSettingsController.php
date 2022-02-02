<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StoreSettingsController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $generalSettings = resolve('general_settings');

        foreach ($request->all() as $key => $value) {
            $generalSettings->{$key} = $value;
        }

        $generalSettings->save();

        return redirect(route('admin.settings.show'));
    }
}
