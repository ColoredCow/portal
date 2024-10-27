<?php

namespace Modules\AppointmentSlots\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\AppointmentSlots\Entities\AppointmentSlot;
use Modules\User\Entities\User;

class AppointmentSlotsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('employee_appointmentslots.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('employee_appointmentslots.create');
    }

    public function update(User $user, AppointmentSlot $appointmentSlot)
    {
        if ($appointmentSlot->user_id != auth()->id()) {
            return $user->hasPermissionTo('employee_appointmentslots.update');
        }

        return true;
    }

    public function delete(User $user, AppointmentSlot $appointmentSlot)
    {
        if ($appointmentSlot->user_id != auth()->id()) {
            return $user->hasPermissionTo('employee_appointmentslots.delete');
        }

        return true;
    }
}
