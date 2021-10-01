<?php

namespace Modules\User\Policies;

use Modules\User\Entities\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('user_management.view');
    }

    public function delete(User $user)
    {
        return $user->can('user_management.delete');
    }
}
