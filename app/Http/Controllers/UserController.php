<?php

namespace App\Http\Controllers;

use App\Services\GSuiteUserService;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $users[] = auth()->user();
        $gsuiteUser = new GSuiteUserService();
        $gsuiteUser->fetch($users[0]->email);
        $gsuiteUsers = $gsuiteUser->getUsers();
        $this->updateGsuiteUser($users, $gsuiteUsers);
        return redirect()->back();
    }

    public function adminSyncWithGsuite()
    {
        if (auth()->user()->isSuperAdmin()) {
            $users = User::all();
            $gsuiteUser = new GSuiteUserService();
            $gsuiteUser->usersFetchByAdmin($users[0]->email);
            $gsuiteUsers = $gsuiteUser->getUsers();
            $this->updateGsuiteUser($users, $gsuiteUsers);
            return redirect()->back();
        }
        abort(403);
    }

    public function updateGsuiteUser($currentUser, $gsuiteUsers)
    {
        foreach ($gsuiteUsers as $key => $gsuiteUser) {
            $currentUser[$key]->employee->update([
                'name' => $gsuiteUser->getName()->fullName,
                'joined_on' => Carbon::parse($gsuiteUser->getCreationTime())->format(config('constants.date_format')),
                'designation' => $gsuiteUser->getOrganizations()[0]['title'],
            ]);
        }
    }
}
