<?php

namespace App\Http\Controllers;

use App\Services\GSuiteUserService;
use App\User;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $currentUser = auth()->user();
        if (!$currentUser->isSuperAdmin()) {
            $allUserList = User::all();
            $this->adminSyncWithGsuite($allUserList, $currentUser);
        } else {
            $gsuiteUser = new GSuiteUserService();
            $gsuiteUser->fetch($currentUser->email);
            $this->updateGsuiteUser($currentUser, $gsuiteUser);
        }
        return redirect()->back();
    }

    public function adminSyncWithGsuite($allUserList, $currentUser)
    {
        //$j used as counter to pass in the function
        $j = 0;
        $gsuiteUser = new GSuiteUserService();
        $gsuiteUser->fetchAdmin($currentUser->email, $j);

        foreach ($allUserList as $user) {
            $j = $j + 1;
            $gsuiteUser->fetchAdmin($gsuiteUser->getPrimaryEmail(), $j);
            $this->updateGsuiteUser($user, $gsuiteUser);
        }
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
