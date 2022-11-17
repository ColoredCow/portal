<?php

namespace Modules\HR\Providers;

use Modules\HR\Entities\Job;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\University;
use Module\HR\Entities\Hrjobdesignation;
use Modules\HR\Policies\EmployeePolicy;
use Modules\HR\Policies\UniversityPolicy;
use Modules\HR\Policies\Recruitment\JobPolicy;
use Module\HR\Policies\HrJobDesignationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class HRAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        University::class => UniversityPolicy::class,
        Job::class => JobPolicy::class,
        Employee::class => EmployeePolicy::class,
        HrJobDesignation::class => HrJobDesignationPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
