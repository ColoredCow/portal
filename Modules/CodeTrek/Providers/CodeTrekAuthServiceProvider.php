<?php

namespace Modules\CodeTrek\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Policies\CodeTrekApplicantPolicy;

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
