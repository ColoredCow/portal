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
    public function BackupView(User $user)
    {
        return $user->hasPermissionTo('infrastructure.backups.view');
    }
    public function BillingView(User $user)
    {
        return $user->hasPermissionTo('infrastructure.billings.view');
    }
    public function Ec2InstancesView(User $user)
    {
        return $user->hasPermissionTo('infrastructure.ec2-instances.view');
    }
}
