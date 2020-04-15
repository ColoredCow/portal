<?php

namespace App\Policies\Finance;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasPermissionTo('finance_reports.view');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('finance_reports.view');
    }
}
