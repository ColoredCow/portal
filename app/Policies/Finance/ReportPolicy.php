<?php

namespace App\Policies\Finance;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

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
