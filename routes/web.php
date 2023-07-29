<?php

use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\EngineController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\SeriesController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\DiscordController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\IndexController;

Route::get('', IndexController::class)->name('index');

Route::group(['prefix' => 'admin/', 'as' => 'admin.', 'middleware' => 'is_admin'], function () {
    Route::get('series', [SeriesController::class, 'index'])->name('series.index');
    Route::get('series/create', [SeriesController::class, 'create'])->name('series.create');
    Route::post('series', [SeriesController::class, 'store'])->name('series.store');
    Route::get('series/{series}/edit', [SeriesController::class, 'edit'])->name('series.edit');
    Route::put('series/{series}', [SeriesController::class, 'update'])->name('series.update');

    Route::group(['prefix' => 'series/{series}'], function () {
        Route::resource('teams', TeamController::class);
        Route::resource('engines', EngineController::class);
    });

    Route::resource('series/{series}/seasons', SeasonController::class)->except('destroy');
    Route::resource('users', UserController::class)->except('destroy');
    Route::resource('drivers', DriverController::class)->except('destroy');
});

Route::get('auth/discord/redirect', [DiscordController::class, 'redirect'])->name('auth.discord.redirect');
Route::get('auth/discord/callback', [DiscordController::class, 'callback'])->name('auth.discord.callback');
Route::post('auth/logout', LogoutController::class)->name('auth.logout');
