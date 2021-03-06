<?php

use App\Http\Controllers\Action\AddDriverToTeamController;
use App\Http\Controllers\Action\DeleteDriverFromTeamController;
use App\Http\Controllers\Actions\ShowIndexPageController;
use App\Http\Controllers\Actions\ShowSettingsPageController;
use App\Http\Controllers\Actions\StoreSettingsController;
use App\Http\Controllers\Actions\UpdateDriverRatingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\DiscordController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('', ShowIndexPageController::class)->name('index');

Route::get('/auth/discord/redirect', [DiscordController::class, 'redirect'])->name('auth.discord.redirect');
Route::get('/auth/discord/callback', [DiscordController::class, 'callback'])->name('auth.discord.callback');

Route::group(['prefix' => config('app.admin_panel_url'), 'as' => 'admin.'], function () {
    Route::get('login', [AdminController::class, 'login'])->name('login');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('', [AdminController::class, 'index'])->name('index');

        Route::resource('series', SeriesController::class)->except('destroy');
        Route::resource('owners', OwnerController::class)->except('destroy');
        Route::resource('teams', TeamController::class)->except('destroy');
        Route::resource('drivers', DriverController::class)->except('destroy');


        Route::get('settings', ShowSettingsPageController::class)->name('settings.show');
        Route::post('settings', StoreSettingsController::class)->name('settings.store')->middleware('settings.filter');

        Route::put('drivers/ratings/update', UpdateDriverRatingController::class)->name('drivers.ratings.update');

        Route::delete('{team}/{driver}', DeleteDriverFromTeamController::class)->name('teams.driver.delete');
        Route::put('{team}/{driver}', AddDriverToTeamController::class)->name('teams.driver.add');
    });
});
