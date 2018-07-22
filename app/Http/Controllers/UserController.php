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

        $user->employee->update([
            'name' => $gsuiteUser->getName(),
            'joined_on' => $gsuiteUser->getJoinedOn(),
            'designation' => $gsuiteUser->getDesignation(),
        ]);

        return redirect()->back();
    }

    public function update(UpdateUserRolesRequest $request, User $user)
    {
        $validatedData = $request->validated();
        if (!isset($validatedData['roles'])) {
            return response()->json([
                'isUpdated' => false,
            ]);
        }
        $roles = array_pluck($validatedData['roles'], 'id');
        $isUpdated = $user->roles()->sync($roles);
        return response()->json(['isUpdated' => $isUpdated]);
    }
}
