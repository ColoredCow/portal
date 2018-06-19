<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Directory;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(env('GOOGLE_SERVICE_ACCOUNT_IMPERSONATE'));
        $client->addScope([
            Google_Service_Directory::ADMIN_DIRECTORY_USER,
            Google_Service_Directory::ADMIN_DIRECTORY_USER_READONLY,
        ]);
        $service = new Google_Service_Directory($client);

        $user = auth()->user();
        $employee = $user->employee;

        $gsuiteUser = $service->users->get($user->email);
        $userOrganizations = $gsuiteUser->getOrganizations();

        $designation = null;
        if (!is_null($userOrganizations)) {
            $designation = $userOrganizations[0]['title'];
        }
        $employee->update([
            'joined_on' => Carbon::parse($gsuiteUser->getCreationTime())->format('Y-m-d'),
            'designation' => $designation,
            'name' => $gsuiteUser->getName()->fullName,
        ]);

        return redirect()->back();
    }
}
