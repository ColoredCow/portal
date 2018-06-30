<?php

namespace App\Services;

use App\Facades\Tenant;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginService
{
    /**
     * Logs in a user authenticated via socialite
     *
     * @return string The home URL of the user
     */
    public static function login()
    {
        $user = session('user', null);
        $provider = session('provider', null);
        if (!$user || !$provider) {
            return false;
        }

        $domain = Tenant::resolveName($user->user['domain']);
        Tenant::setUpForDomain($domain);
        Tenant::setUpDBConnection();

        session(['active_connection' => Tenant::organization()->connection_name]);
        session()->flash('status', 'Welcome to ' . Tenant::organization()->name);

        $authUser = self::findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        $authUser->update(['avatar' => $user->avatar_original]);

        return Tenant::getUrl(Tenant::organization()->slug);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    protected static function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'avatar' => '',
        ]);
    }
}
