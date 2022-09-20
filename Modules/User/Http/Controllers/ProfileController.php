<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Contracts\ProfileServiceContract;
use Modules\User\Entities\User;
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
        $user->employee->designation = $request->designation;
        $user->employee->name = $request->name;
        $user->employee->domain_id = $request->domainId;
        $user->profile->mobile = $request->mobile;
        $user->profile->gender = $request->gender;
        $user->profile->date_of_birth = $request->date_of_birth;
        $user->profile->husband_name = $request->husband_name;
        $user->profile->date_of_joining = $request->date_of_joining;
        $user->profile->father_name = $request->father_name;
        $user->profile->marital_status = $request->marital_status;
        $user->profile->current_location = $request->current_location;

        $user->push();

        return back();
    }
}
