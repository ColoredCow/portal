<?php

namespace App\Http\Controllers;

use App\Services\GSuiteUserService;
use App\User;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            $users = User::all();
            $this->adminSyncWithGsuite($users, $user);
        } else {
            $gsuiteUser = new GSuiteUserService();
            $gsuiteUser->fetch($user->email);
            $this->updateGsuiteUser($user, $gsuiteUser);
        }
        return redirect()->back();
    }

    public function adminSyncWithGsuite($users, $user)
    {
        //$j used as counter to pass in the function
        $j = 0;
        $gsuiteUser = new GSuiteUserService();
        $gsuiteUser->fetch($user->email);

        foreach ($users as $user) {
            $j = $j + 1;
            $gsuiteUser->fetchAdmin($gsuiteUser->getPrimaryEmail(), $j);
            $this->updateGsuiteUser($user, $gsuiteUser);
        }
    }

    public function updateGsuiteUser($user, $gsuiteUser)
    {
        $user->employee->update([
            'name' => $gsuiteUser->getName(),
            'joined_on' => $gsuiteUser->getJoinedOn(),
            'designation' => $gsuiteUser->getDesignation(),
        ]);
    }
}
