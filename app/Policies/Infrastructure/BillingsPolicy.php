<?php

namespace App\Policies\Infrastructure;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class BillingsPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view the .
     *
     * @param  \Modules\User\Entities\User  $user
     *
     * @return mixed
     */
    public function backupView(User $user)
    {
        return $user->hasPermissionTo('infrastructure.backups.view');
    }
    public function billingView(User $user)
    {
        return $user->hasPermissionTo('infrastructure.billings.view');
    }
    public function ec2InstancesView(User $user)
    {
        return $user->hasPermissionTo('infrastructure.ec2-instances.view');
    }
}
