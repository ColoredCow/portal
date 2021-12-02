<?php

namespace Modules\Project\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Project\Entities\Project;
use Modules\Project\Policies\ProjectPolicy;

class ProjectAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
