<?php

namespace Modules\Project\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Entities\ProjectInvoiceTerm;
use Modules\Project\Policies\ProjectContractPolicy;
use Modules\Project\Policies\ProjectInvoiceTermPolicy;
use Modules\Project\Policies\ProjectPolicy;

class ProjectAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Project::class => ProjectPolicy::class,
        ProjectContract::class => ProjectContractPolicy::class,
        ProjectInvoiceTerm::class => ProjectInvoiceTermPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
