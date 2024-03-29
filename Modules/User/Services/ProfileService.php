<?php

namespace Modules\User\Services;

use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;
use Modules\User\Contracts\ProfileServiceContract;

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
        $designation = HrJobDesignation::select('id', 'designation', 'domain_id')->get()->toArray();
        $domainIndex = '';

        return ['user' => $user, 'section' => $section, 'domains' =>$domains, 'designations' => $designation, 'domainIndex' => $domainIndex];
    }
}
