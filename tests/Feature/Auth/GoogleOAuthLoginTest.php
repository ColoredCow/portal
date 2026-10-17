<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Modules\User\Entities\User;
use Tests\TestCase;

class GoogleOAuthLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_redirects_to_google_when_initiating_oauth()
    {
        $provider = \Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
        $provider->shouldReceive('with')->andReturnSelf();
        $provider->shouldReceive('scopes')->andReturnSelf();
        $provider->shouldReceive('redirect')->andReturn(redirect('https://accounts.google.com/o/oauth2/auth'));

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $this->get('/auth/google')->assertRedirect();
    }

    /** @test */
    public function it_logs_in_an_existing_user_via_google_callback()
    {
        $user = User::factory()->create([
            'email' => 'existing@coloredcow.in',
            'provider_id' => '111222333',
        ]);
        $this->mockGoogleCallback(['id' => '111222333', 'email' => 'existing@coloredcow.in']);

        $this->get('/auth/google/callback')->assertRedirect('home');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_redirects_a_soft_deleted_user_back_to_login()
    {
        $user = User::factory()->create(['email' => 'deleted@coloredcow.in']);
        $user->delete();

        $this->mockGoogleCallback(['email' => 'deleted@coloredcow.in']);

        $this->get('/auth/google/callback')->assertRedirect('login');

        $this->assertGuest();
    }

    /** @test */
    public function it_creates_a_new_user_on_first_google_login_and_redirects_to_home()
    {
        \Spatie\Permission\Models\Role::create(['name' => 'book-manager', 'guard_name' => 'web']);

        $this->mockGoogleCallback([
            'id' => '987654321',
            'name' => 'Brand New',
            'email' => 'brandnew@coloredcow.in',
        ]);

        $this->get('/auth/google/callback')->assertRedirect('home');

        $this->assertDatabaseHas('users', ['email' => 'brandnew@coloredcow.in']);
    }

    private function mockGoogleCallback(array $attrs = [])
    {
        $socialiteUser = (object) array_merge([
            'id' => '123456789',
            'name' => 'Test User',
            'email' => 'test@coloredcow.in',
            'avatar' => null,
            'avatar_original' => null,
        ], $attrs);

        $provider = \Mockery::mock(\Laravel\Socialite\Contracts\Provider::class);
        $provider->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        return $socialiteUser;
    }
}
