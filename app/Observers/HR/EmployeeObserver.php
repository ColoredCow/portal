<?php

namespace App\Observers\HR;

use App\Models\HR\Employee;
use App\Services\GSuiteUserService;

class EmployeeObserver {
    /**
     * Handle to the employee "created" event.
     *
     * @param  \App\Models\HR\Employee  $employee
     * @return void
     */
    public function created(Employee $employee) {
        if (app()->environment('testing')) {
            return;
        }

    $gsuiteUserService = new GSuiteUserService;
    $gsuiteUserService->fetch($employee->user->email);

    foreach ($gsuiteUserService->getUsers() as $gsuiteUser) {
        $user = User::with('employee')->findByEmail($gsuiteUser->getPrimaryEmail())->first();
        if (is_null($user)) {
            continue;
        }
        $employee->update([
            'name' => $gsuiteUser->getName()->fullName,
            'joined_on' => Carbon::parse($gsuiteUser->getCreationTime())->format(config('constants.date_format')),
            'designation' => $gsuiteUser->getOrganizations()[0]['title'],
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
