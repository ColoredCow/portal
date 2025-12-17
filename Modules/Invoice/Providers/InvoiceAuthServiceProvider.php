<?php

namespace Modules\Invoice\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Policies\InvoicePolicy;

class InvoiceAuthServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Invoice::class => InvoicePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
