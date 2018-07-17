<?php

namespace App\Http\Controllers;

use App\Services\GSuiteUserService;
use App\User;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $user[] = auth()->user();

        if ($user[0]->isSuperAdmin()) {
            $user = User::all();
        }

        $gsuiteUser = new GSuiteUserService();
        $gsuiteUser->fetch(auth()->user()->email);

        foreach ($user as $i => $user[]) {
            $user[$i]->employee->update([
                'name' => $gsuiteUser->getName()[$i],
                'joined_on' => $gsuiteUser->getJoinedOn()[$i],
                'designation' => $gsuiteUser->getDesignation()[$i],
            ]);
        }

        return redirect()->back();
    }
}
