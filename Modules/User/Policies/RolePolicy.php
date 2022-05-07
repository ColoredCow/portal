<?php

namespace Modules\User\Policies;

use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user)
    {
        return $user->can('role.view');
    }

    public function create(User $user, Role $role)
    {
        return $user->can('role.create');
    }

    public function update(User $user, Role $role)
    {
        return $user->can('role.update');
    }

    public function destroy(User $user, Role $role)
    {
        return $user->can('role.delete');
    }
}
