<?php

namespace App\Http\Controllers;

use App\Services\GSuiteUserService;
use App\User;

class UserController extends Controller
{
    public function syncWithGSuite($user = null)
    {
        if ($user == null) {
            $user = auth()->user();
        }
        $gsuiteUser = new GSuiteUserService();
        $gsuiteUser->fetch($user->email);
        $this->updateGsuiteUser($user, $gsuiteUser);
        return redirect()->back();
    }

    public function adminSyncWithGsuite()
    {
        if (auth()->user()->isSuperAdmin()) {
            $users = User::all();
            foreach ($users as $user) {
                self::syncWithGSuite($user);
            }
            return redirect()->back();
        }
        abort(403);
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
