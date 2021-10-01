<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Contracts\ProfileServiceContract;

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
}
