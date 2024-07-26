<?php

namespace Modules\User\Http\Controllers;

use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Http\Requests\ProfileEditRequest;
use Modules\User\Contracts\ProfileServiceContract;
use Modules\User\Entities\User;
use Modules\User\Entities\UserProfile;

class ProfileController extends ModuleBaseController
{
    protected $service;

    public function __construct(ProfileServiceContract $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('user::profile.index', $this->service->index());
    }

    public function update(ProfileEditRequest $request, $userId)
    {
        $user = User::withTrashed()->find($userId);
        $user->name = $request->name;
        $user->nickname = $request->nickName;
        $user->employee->name = $request->name;
        $user->employee->designation_id = $request->designationId;

        $designation = HrJobDesignation::find($request->designationId)->slug;
        if ($user->profile != null) {
            $user->profile->mobile = $request->mobile;
            $user->profile->spouse_name = $request->spouse_name;
            $user->profile->father_name = $request->father_name;
            $user->profile->marital_status = $request->marital_status;
            $user->profile->current_location = $request->current_location;
            $user->profile->designation = $designation;
            $user->profile->address = $request->address;
            $user->profile->insurance_tenants = $request->insurance_tenants;
            $user->profile->save();
        } else {
            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
            $userProfile->father_name = $request->father_name;
            $userProfile->mobile = $request->mobile;
            $userProfile->marital_status = $request->marital_status;
            $userProfile->spouse_name = $request->spouse_name;
            $userProfile->current_location = $request->current_location;
            $userProfile->designation = $designation;
            $userProfile->address = $request->address;
            $userProfile->insurance_tenants = $request->insurance_tenants;
            $userProfile->save();
        }
        
        $user->employee->save();

        $user->save();
        $user->employee->save();

        return back();
    }
}
