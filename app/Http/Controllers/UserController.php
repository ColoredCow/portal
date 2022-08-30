<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;
use App\Services\GSuiteUserService;

class UserController extends Controller
{
    public function syncWithGSuite()
    {
        $this->authorize('syncWithGSuite', self::class);

        $gsuiteUserService = new GSuiteUserService();
        $gsuiteUserService->fetch(auth()->user()->email);
        $this->updateEmployeeDetailsFromGSuite($gsuiteUserService->getUsers());

        return redirect()->back();
    }

    public function syncAllWithGSuite()
    {
        $this->authorize('syncAllWithGSuite', self::class);
        $gsuiteUserService = new GSuiteUserService();
        $gsuiteUserService->fetchAll();
        $this->updateEmployeeDetailsFromGSuite($gsuiteUserService->getUsers());

        return redirect()->back();
    }

    public function updateEmployeeDetailsFromGSuite(array $gsuiteUsers)
    {
        foreach ($gsuiteUsers as $gsuiteUser) {
            $user = User::with('employee')->findByEmail($gsuiteUser->getPrimaryEmail())->first();
            if (is_null($user)) {
                continue;
            }
            $user->employee->update([
                'name' => $gsuiteUser->getName()->fullName,
                'joined_on' => Carbon::parse($gsuiteUser->getCreationTime())->format(config('constants.date_format')),
                'designation' => $gsuiteUser->getOrganizations()[0]['title'],
            ]);
        }
    }

    public function projects()
    {
        $userProjects = Auth::user()->activeProjects();

        return $userProjects;
    }

    public function userEffort()
    {
        $effort = Auth::user()->userEfforts();

        return $effort;
    }
}
