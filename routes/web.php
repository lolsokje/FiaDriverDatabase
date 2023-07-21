<?php

use App\Http\Controllers\Admin\SeriesController;
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
});

Route::get('auth/discord/redirect', [DiscordController::class, 'redirect'])->name('auth.discord.redirect');
Route::get('auth/discord/callback', [DiscordController::class, 'callback'])->name('auth.discord.callback');
Route::post('auth/logout', LogoutController::class)->name('auth.logout');
