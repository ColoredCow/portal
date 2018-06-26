<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Facades\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        switch ($provider) {
            case 'google':
                return Socialite::driver($provider)->redirect();
                break;

            default:
                return Socialite::driver($provider)->redirect();
                break;
        }
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $domain = Tenant::resolveName($user->user['domain']);
        Tenant::setUpForDomain($domain);

        if (!Tenant::organization()) {
            return redirect()->route('organizations.create');
        }

        // need to check now if the domain is already registered within the organizations table.
        // If yes, redirect to the user workspace.
        $organizationUrl = Tenant::getUrl($domain);
        session()->flash('status', 'Welcome to '. Tenant::organization()->name);

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        $authUser->update(['avatar' => $user->avatar_original]);
        
        return redirect()->to($organizationUrl . '/home');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
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
        ]);
    }
}
