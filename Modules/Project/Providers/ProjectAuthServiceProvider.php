<?php
namespace Modules\Project\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Project\Entities\Project;
use Modules\Project\Policies\ProjectPolicy;

class ProjectAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
