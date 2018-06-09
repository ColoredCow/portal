<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeCafe\Library\Book;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Directory;

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
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(config('constants.gsuite.service-account-impersonate'));
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $service = new Google_Service_Calendar($client);

        $eventId = 'uehh5gk7bbq580lj4e4kb2bk3k';
        $event = $service->events->get('primary', $eventId);

        dd($event);
        dd($event->hangoutLink, $event->getSummary());

        $unreadBook = Book::getRandomUnreadBook();
        return view('home')->with(['book' => $unreadBook]);
    }

    /**
     * Fetch a user's groups from GSuite API
     * @param  string $email Email of the user
     * @return array        List of groups
     */
    public function getUserGroups($email)
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(env('GOOGLE_SERVICE_ACCOUNT_IMPERSONATE'));
        $client->addScope([
            Google_Service_Directory::ADMIN_DIRECTORY_GROUP,
            Google_Service_Directory::ADMIN_DIRECTORY_GROUP_READONLY,
        ]);

        $dir = new Google_Service_Directory($client);
        $googleGroups = $dir->groups->listGroups([
            'userKey' => $email,
        ]);
        $groups = $googleGroups->getGroups();

        $userGroups = [];
        if (sizeof($groups)) {
            foreach ($groups as $group) {
                $userGroups[$group->email] = $group->name;
            }
        }
        return $userGroups;
    }
}
