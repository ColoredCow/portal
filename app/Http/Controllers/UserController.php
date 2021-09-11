<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Auth;
use App\Services\GSuiteUserService;
use Modules\User\Entities\UserMeta;
use Illuminate\Http\Request;

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
        $userProjects = Auth::user()->projects;

        return $userProjects;
    }

    public function index()
    {
        return view('user::user-settings.index');
    }

    public function update(Request $request)
    {
        UserMeta::updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['max_interviews_per_day' => $request->max_interviews_per_day]
        );

        return redirect()->back()->with('status', 'Saved Successfully!');
    }
}
