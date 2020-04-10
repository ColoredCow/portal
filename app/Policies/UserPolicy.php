<?php

namespace App\Policies;

use Modules\User\Entities\User;
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
