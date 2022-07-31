<?php

namespace Modules\Invoice\Providers;

use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Policies\InvoicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

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
