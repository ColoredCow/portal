<?php

namespace Modules\Project\Providers;

use Modules\Project\Entities\Project;
use Modules\Project\Policies\ProjectPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class ProjectAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
