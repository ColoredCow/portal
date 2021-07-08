<?php

namespace Modules\HR\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\University;
use Modules\HR\Policies\Recruitment\JobPolicy;
use Modules\HR\Policies\UniversityPolicy;

class HRAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        University::class => UniversityPolicy::class,
        Job::class => JobPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
