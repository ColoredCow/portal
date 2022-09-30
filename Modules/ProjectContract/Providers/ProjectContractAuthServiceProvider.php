<?php

namespace Modules\ProjectContract\Providers;

use Modules\ProjectContract\Entities\ProjectContractMeta;
use Modules\ProjectContract\Policies\ProjectContractPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class ProjectContractAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        ProjectContractMeta::class => ProjectContractPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
