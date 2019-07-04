<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeCafe\Library\Book;
use Google_Client;
use Google_Service_Directory;
use GrahamCampbell\GitHub\Facades\GitHub;
use Github\Client;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = 'query($owner:String!,$name:String!,$milestoneNumber:Int!) {
            repository(owner:$owner,name:$name) {
              milestone(number:$milestoneNumber) {
                issues(last:100) {
                  edges {
                    node {
                      title
                      bodyText
                      author {
                        login
                      }
                    }
                  }
                }
              }
            }
          }';

        $variables = [
            'owner' => 'pankaj-ag',
            'name' => 'laravel-CCDA',
            'milestoneNumber' => 1
        ];

        $client = app()->make(Client::class) ;  //GitHub::issues()->show('coloredcow', 'caped-app');

        $issues = $client->api('issue')->all('pankaj-ag', 'laravel-CCDA');
        dd($issues);
        $orgInfo = $client->api('graphql')->execute($query, $variables);

        $tasks = $orgInfo['data']['repository']['milestone']['issues']['edges'] ?? [];

        dd($orgInfo);

        $milestones = collect($client->api('issue')->all('coloredcow', 'caped-app'));

        dd($milestones);

        $unreadBook = (session('disable_book_suggestion')) ? null : Book::getRandomUnreadBook();
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

    public function saveData(Request $request)
    {
        return GithubTask::create(['user_name' => $request->input('user')]);
    }
}
