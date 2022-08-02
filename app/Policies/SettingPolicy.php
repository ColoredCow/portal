<?php

namespace App\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasAnyPermission([
            'hr_settings.view',
            'nda_settings.view',
            'finance_invoices_settings.view',
        ]);
    }

    public function update(User $user)
    {
        return $user->hasAnyPermission([
            'hr_settings.update',
            'nda_settings.update',
            'finance_invoices_settings.update',
        ]);
    }

    public function viewAny(User $user)
    {
        return $user->hasAnyPermission([
            'hr_settings.view',
            'nda_settings.view',
            'finance_invoices_settings.view',
        ]);
    }
}
