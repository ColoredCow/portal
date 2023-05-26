<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Directory;
use App\Models\KnowledgeCafe\Library\Book;
use Modules\User\Entities\UserMeta;
use Modules\Operations\Entities\OfficeLocation;
use Illuminate\Http\Request;

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
        $centres = OfficeLocation::orderBy('centre_name', 'asc')->get();

        $selectedLocation = auth()->user()->office_location;

        return view('home')->with([
            'book' => $unreadBook,
            'centres' => $centres,
            'selectedLocation' => $selectedLocation,
        ]);
    }    

    /**
     * Fetch a user's groups from GSuite API.
     *
     * @param  string $email Email of the user
     * @return array         List of groups
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

    public function storeEmployeeLocation(Request $request)
    {
        $validatedData = $request->validate([
            'centre_name' => 'required|exists:office_locations,centre_name',
        ]);

        $userMeta = UserMeta::updateOrCreate(
            ['user_id' => auth()->user()->id, 'meta_key' => 'office_location'],
            ['meta_value' => $request->centre_name]
        );

        return redirect('home');
    }
}
