<?php

namespace Modules\HR\Observers;

use App\Services\GSuiteUserService;
use Carbon\Carbon;
use Modules\HR\Entities\Employee;
use Modules\User\Entities\User;

class EmployeeObserver
{
    /**
     * Handle to the employee "created" event.
     *
     * @param  Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        if (app()->environment('testing') || app()->environment('local')) {
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
            ]);
        }
    }
}
