<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

        if (!in_array($discordId, config('discord.admin_ids'))) {
            return redirect(route('index'))->with('error', "You're not supposed to log in");
        }

        $user = User::updateOrCreate([
            'discord_id' => $discordId
        ], [
            'username' => $discordUser->getName(),
            'is_admin' => true,
        ]);

        Auth::login($user);

        return redirect(route('index'))->with('notice', 'Logged in as admin');
    }
}
