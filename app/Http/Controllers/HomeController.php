<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Google_Client;
use Google_Service_Directory;
use App\Models\KnowledgeCafe\Library\Book;

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
     */

    public function index()
    {
        $unreadBook = (session('disable_book_suggestion')) ? null : Book::getRandomUnreadBook();
        $name = auth()->user()->name;
        // FTE = Sum of hours booked by an employee in all the projects/(total number of days in month till today *8)
        $id = DB::table('users')->where('name', $name)->value('id');
        $efforts = DB::table('project_team_members_effort')->where('project_team_member_id', $id)->whereMonth('added_on', date('m'))->sum('actual_effort');
        $FTE = $efforts / (date('d')*8.00);
        return view('home')->with(['book' => $unreadBook, 'FTE'=>$FTE]);
    }

    /**
     * Fetch a user's groups from GSuite API.
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
        if (count($groups)) {
            foreach ($groups as $group) {
                $userGroups[$group->email] = $group->name;
            }
        }

        return $userGroups;
    }
}
