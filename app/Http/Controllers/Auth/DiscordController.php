<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class DiscordController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('discord')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $discordUser = Socialite::driver('discord')->user();

        $discordId = $discordUser->getId();

        $isAdmin = in_array($discordId, config('discord.admin_ids'));

        $user = User::query()
            ->updateOrCreate([
                'discord_id' => $discordId,
            ], [
                'username' => $discordUser->getName(),
                'admin' => $isAdmin,
            ]);

        Auth::login($user);

        return to_route('index');
    }
}
