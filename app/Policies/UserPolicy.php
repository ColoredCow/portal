<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

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
