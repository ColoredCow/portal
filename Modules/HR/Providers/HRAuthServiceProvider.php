<?php

namespace Modules\HR\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\JobRequisition;
use Modules\HR\Entities\University;
use Modules\HR\Policies\EmployeePolicy;
use Modules\HR\Policies\HrJobDesignationPolicy;
use Modules\HR\Policies\JobRequisitionPolicy;
use Modules\HR\Policies\Recruitment\JobPolicy;
use Modules\HR\Policies\UniversityPolicy;

class HRAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        University::class => UniversityPolicy::class,
        Job::class => JobPolicy::class,
        Employee::class => EmployeePolicy::class,
        HrJobDesignation::class => HrJobDesignationPolicy::class,
        JobRequisition::class => JobRequisitionPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
