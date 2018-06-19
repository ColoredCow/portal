<?php

namespace App\Observers\HR;

use App\Models\HR\Employee;
use App\Services\GuiteUserService;

class EmployeeObserver
{
    /**
     * Handle to the employee "created" event.
     *
     * @param  \App\Models\HR\Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        $gsuiteUser = new GuiteUserService;
        $gsuiteUser->fetch($employee->user->email);
        $user->employee->update([
            'name' => $gsuiteUser->getName(),
            'joined_on' => $gsuiteUser->getJoinedOn(),
            'designation' => $gsuiteUser->getDesignation(),
        ]);
    }

    /**
     * Handle the employee "updated" event.
     *
     * @param  \App\Models\HR\Employee  $employee
     * @return void
     */
    public function updated(Employee $employee)
    {
        if ($employee->user->name != $employee->name) {
            $employee->user->update([
                'name' => $employee->name,
            ]);
        }
    }
}
