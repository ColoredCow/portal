<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = session('oauthuser');

        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(env('GOOGLE_SERVICE_ACCOUNT_IMPERSONATE'));

        $client->addScope([
            'https://www.googleapis.com/auth/admin.directory.group',
            'https://www.googleapis.com/auth/admin.directory.group.readonly',
        ]);
        $httpClient = $client->authorize();
        $response = $httpClient->get('https://www.googleapis.com/admin/directory/v1/groups?userKey=' . urlencode($user->email));
        $contents = json_decode((string) $response->getBody(), true);

        $userGroups = [];
        if (sizeof($contents) && array_key_exists('groups', $contents)) {
            foreach ($contents['groups'] as $group) {
                $userGroups[$group['email']] = $group['name'];
            }
        }

        return view('home')->with([
            'user' => $user,
            'groups' => $userGroups,
        ]);
    }
}
