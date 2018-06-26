<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TenantService;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \Tenant::setUpDBConnection();
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TenantService::class, function ($app) {
            return new TenantService;
        });
    }
}
