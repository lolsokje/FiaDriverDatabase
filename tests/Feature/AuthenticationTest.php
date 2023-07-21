<?php

use App\Models\User;

it('redirects the user to Discord', function () {
    $this->get(route('auth.discord.redirect'))
        ->assertRedirect();
});

it('creates missing users after logging in through discord', function () {
    setupSocialiteMocking();

    $this->get(route('auth.discord.callback'))
        ->assertRedirectToRoute('index');

    $this->assertCount(1, User::all());
    $this->assertEquals('username', User::first()->username);
});

it('updates existing users after logging in through discord', function () {
    setupSocialiteMocking();

    User::factory()->create([
        'discord_id' => '123456789',
        'username' => 'unchanged',
    ]);

    $this->get(route('auth.discord.callback'))
        ->assertRedirectToRoute('index');

    $this->assertCount(1, User::all());
    $this->assertEquals('username', User::first()->username);
});

it('logs users in after authenticated through discord', function () {
    setupSocialiteMocking();

    $this->get(route('auth.discord.callback'))
        ->assertRedirectToRoute('index');

    $this->assertNotNull(Auth::user());
    $this->assertEquals(Auth::id(), User::first()->id);
});

it('marks the correct users as admin', function () {
    setupSocialiteMocking('123');
    Config::set('discord.admin_ids', ['123']);

    $this->get(route('auth.discord.callback'))
        ->assertRedirectToRoute('index');

    $this->assertTrue(User::first()->admin);
});

it('does not mark non admins as admin', function () {
    setupSocialiteMocking();

    $this->get(route('auth.discord.callback'))
        ->assertRedirectToRoute('index');

    $this->assertFalse(User::first()->admin);
});

test('a user can logout', function () {
    $user = User::factory()->create();

    Auth::login($user);

    $this->assertNotNull(Auth::user());
    $this->assertAuthenticatedAs($user);

    $this->post(route('auth.logout'))
        ->assertRedirectToRoute('index');

    $this->assertNull(Auth::user());
});

function setupSocialiteMocking(
    ?string $id = '123456789',
    ?string $username = 'username',
): void {
    $mockedUser = Mockery::mock(Laravel\Socialite\Two\User::class);

    $mockedUser->shouldReceive('getId')->andReturn($id);
    $mockedUser->shouldReceive('getName')->andReturn($username);

    $mockedProvider = Mockery::mock(Laravel\Socialite\Contracts\Provider::class);
    $mockedProvider->shouldReceive('user')->andReturn($mockedUser);

    Socialite::shouldReceive('driver')->andReturn($mockedProvider);
}
