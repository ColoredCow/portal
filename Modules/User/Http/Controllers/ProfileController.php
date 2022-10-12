<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Contracts\ProfileServiceContract;
use Modules\User\Entities\User;
use Modules\User\Entities\UserProfile;
use Modules\HR\Http\Requests\ProfileEditRequest;

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

    public function update(ProfileEditRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->nickname = $request->nickName;
        $user->employee->name = $request->name;
        $user->employee->domain_id = $request->domainId;
        if ($user->profile != null) {
            $user->profile->mobile = $request->mobile;
            $user->profile->spouse_name = $request->spouse_name;
            $user->profile->father_name = $request->father_name;
            $user->profile->marital_status = $request->marital_status;
            $user->profile->current_location = $request->current_location;
            $user->profile->designation = $request->designation;
        } else {
            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
            $userProfile->father_name = $request->father_name;
            $userProfile->mobile = $request->mobile;
            $userProfile->marital_status = $request->marital_status;
            $userProfile->spouse_name = $request->spouse_name;
            $userProfile->current_location = $request->current_location;
            $userProfile->designation = $request->designation;
            
            $userProfile->save();
        }
        

        $user->push();

        return back();
    }
}
