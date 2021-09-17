<?php

namespace Modules\User\Services;

use Modules\User\Entities\User;
use OfficeSuite\OfficeSuiteFacade;
use Modules\User\Events\UserRemovedEvent;
use Modules\User\Contracts\UserServiceContract;

class UserService implements UserServiceContract
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with('roles')
            ->orderBy('name')
            ->get();
    }

    public function delete(User $user)
    {
        $user->delete();
        if (config('database.connections.wordpress.enabled')) {
            event(new UserRemovedEvent($user));
        }

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
        if (! isset($data['roles'])) {
            return response()->json([
                'isUpdated' => false,
            ]);
        }
        $user = User::find($data['user_id']);
        $roles = array_pluck($data['roles'], 'id');

        return $user->syncRoles($roles);
    }
}
