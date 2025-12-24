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
     * @param  Employee $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        if (app()->environment('testing') || app()->environment('local')) {
            return;
        }

        $user = $employee->user;

        // Only fetch from Google Workspace if the user is a Google Workspace user
        // External users (provider = 'default') should not be fetched from Google Workspace
        $isGSuiteUser = $user->provider === 'google'
            || strpos($user->email, config('constants.gsuite.client-hd')) !== false;

        if (! $isGSuiteUser) {
            return;
        }

        try {
            $gsuiteUserService = new GSuiteUserService();
            $gsuiteUserService->fetch($user->email);

            $gsuiteUsers = $gsuiteUserService->getUsers();
            if ($gsuiteUsers) {
                foreach ($gsuiteUsers as $gsuiteUser) {
                    $foundUser = User::with('employee')->findByEmail($gsuiteUser->getPrimaryEmail())->first();
                    if (is_null($foundUser)) {
                        continue;
                    }
                    $employee->update([
                        'name' => $gsuiteUser->getName()->fullName,
                        'joined_on' => Carbon::parse($gsuiteUser->getCreationTime())->format(config('constants.date_format')),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silently handle Google API errors (e.g., user not found in Google Workspace)
            // This prevents errors when creating external users or when Google API is unavailable
        }
    }
}
