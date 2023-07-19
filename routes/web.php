<?php

use App\Http\Controllers\Auth\DiscordController;

Route::get('')->name('index');

Route::get('auth/discord/redirect', [DiscordController::class, 'redirect'])->name('auth.discord.redirect');
Route::get('auth/discord/callback', [DiscordController::class, 'callback'])->name('auth.discord.callback');
