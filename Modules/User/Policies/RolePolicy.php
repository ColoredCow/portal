<?php

namespace Modules\User\Policies;

use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user)
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user, Role $role)
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Role $role)
    {
        return $user->isSuperAdmin();
    }

    public function destroy(User $user, Role $role)
    {
        return $user->isSuperAdmin();
    }
}
