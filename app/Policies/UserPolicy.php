<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function syncWithGSuite(User $user)
    {
        return $user->provider == 'google';
    }

    public function syncAllWithGSuite(User $user)
    {
        return $user->isSuperAdmin();
    }

}
