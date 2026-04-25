<?php

namespace Modules\Client\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Client\Entities\ClientContract;
use Modules\Client\Policies\ClientContractPolicy;

class ClientAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        ClientContract::class => ClientContractPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
