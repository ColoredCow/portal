<?php

namespace Modules\CodeTrek\Providers;

use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Policies\CodeTrekApplicantPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class CodeTrekAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        CodeTrekApplicant::class => CodeTrekApplicantPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
