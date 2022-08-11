<?php

namespace Modules\User\Services;

use Modules\User\Contracts\ProfileServiceContract;
use Modules\HR\Entities\HrJobDomain;


class ProfileService implements ProfileServiceContract
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $section = request()->input('section', 'basic-details');
        $domains = HrJobDomain::select('id', 'domain')->get()->toArray();

        return ['user' => $user, 'section' => $section, 'domains' =>$domains];

    }
}
