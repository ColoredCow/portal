<?php

namespace Modules\User\Services;

use Illuminate\Http\Response;
use Modules\User\Entities\User;
use OfficeSuite\OfficeSuiteFacade;
use Modules\User\Events\UserRemovedEvent;

class UserService
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('user::index', compact('users'));
    }

    public function delete(User $user)
    {
        $user->delete();
        event(new UserRemovedEvent($user));
        return OfficeSuiteFacade::removeUser();
        ///TODO:: Fire an event for all the communication and API integrations
    }

    public function update($data)
    {
        $action = $data['_action'] ?? '';
        if ($action == 'assign-roles') {
            return $this->updateUserRoles($data);
        }

        return true;
    }

    public function updateUserRoles($data)
    {
        if (!isset($data['roles'])) {
            return response()->json([
                'isUpdated' => false,
            ]);
        }
        $user = User::find($data['userID']);
        $roles = array_pluck($data['roles'], 'id');
        return $user->syncRoles($roles);
    }
}
