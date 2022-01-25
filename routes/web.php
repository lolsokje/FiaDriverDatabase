<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\DiscordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('index');

Route::get('/auth/discord/redirect', [DiscordController::class, 'redirect'])->name('auth.discord.redirect');
Route::get('/auth/discord/callback', [DiscordController::class, 'callback'])->name('auth.discord.callback');

Route::group(['prefix' => config('app.admin_panel_url'), 'as' => 'admin.'], function () {
    Route::get('', [AdminController::class, 'index'])->name('index');
    Route::get('login', [AdminController::class, 'login'])->name('login');
    
    Route::resource('series', SeriesController::class)->except('destroy');
});
