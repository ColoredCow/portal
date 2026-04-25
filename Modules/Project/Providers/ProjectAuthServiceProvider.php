<?php

namespace Modules\Project\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Policies\ProjectContractPolicy;
use Modules\Project\Policies\ProjectPolicy;

class ProjectAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
        ProjectContract::class => ProjectContractPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
