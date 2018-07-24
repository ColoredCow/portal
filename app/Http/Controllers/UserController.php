<?php

namespace App\Http\Controllers;

use App\Services\GSuiteUserService;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{
    public function syncWithGSuite($user = null)
    {
        if ($user == null) {
            $user = auth()->user();
        }
        $gsuiteUser = new GSuiteUserService();
        $gsuiteUser->fetch($user->email);
        $gsuiteUser = $gsuiteUser->getUsers();
        $this->updateGsuiteUser($user, $gsuiteUser);
        return redirect()->back();
    }

    public function adminSyncWithGsuite()
    {
        if (auth()->user()->isSuperAdmin()) {
            $users = User::all();
            $user = auth()->user();
            $gsuiteUser = new GSuiteUserService();
            $gsuiteUser->usersFetchByAdmin($user->email);
            $gsuiteUsers = $gsuiteUser->getUsers();

            foreach ($gsuiteUsers as $key => $gsuiteUser) {
                $this->updateGsuiteUser($users[$key], $gsuiteUser);
            }
            return redirect()->back();
        }
        abort(403);
    }

    public function updateGsuiteUser($currentUser, $gsuiteUser)
    {
        $currentUser->employee->update([
            'name' => $gsuiteUser->getName()->fullName,
            'joined_on' => Carbon::parse($gsuiteUser->getCreationTime())->format(config('constants.date_format')),
            'designation' => $gsuiteUser->getOrganizations()[0]['title'],
        ]);
    }
}
