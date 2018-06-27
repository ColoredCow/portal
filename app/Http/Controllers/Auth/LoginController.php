<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Tenant;
use App\Http\Controllers\Controller;
use App\Services\LoginService;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

        session([
            'provider' => $provider,
            'user' => $user,
        ]);

        $domain = Tenant::resolveName($user->user['domain']);
        Tenant::setUpForDomain($domain);

        if (!Tenant::organization()) {
            return redirect()->route('organizations.create');
        }
        return redirect()->to(LoginService::login());
    }
}
