<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Entities\User;

class SettingPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->hasAnyPermission([
            'hr_settings.view',
            'nda_settings.view',
            'finance_invoices_settings.view',
            'contractsettings.view',
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
