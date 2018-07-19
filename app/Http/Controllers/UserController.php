<?php

namespace App\Http\Controllers;

use App\Services\GSuiteUserService;
use App\User;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $user = auth()->user();
        $gsuiteUser = new GSuiteUserService();
        $gsuiteUser->fetch($user->email);
        $this->updateGsuiteUser($user, $gsuiteUser);
        return redirect()->back();
    }

    public function adminSyncWithGsuite()
    {
        $users = User::all();
        $j = 0;
        $gsuiteUser = new GSuiteUserService();

        foreach ($users as $user) {
            $j = $j + 1;
            $gsuiteUser->fetchAdmin($user->email, $j);
            $this->updateGsuiteUser($user, $gsuiteUser);
        }
        return redirect()->back();
    }

    public function updateGsuiteUser($currentUser, $gsuiteUser)
    {
        $currentUser->employee->update([
            'name' => $gsuiteUser->getName(),
            'joined_on' => $gsuiteUser->getJoinedOn(),
            'designation' => $gsuiteUser->getDesignation(),
        ]);
    }
}
