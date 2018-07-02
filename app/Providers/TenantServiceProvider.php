<?php

namespace App\Providers;

use App\Services\TenantService;
use Illuminate\Support\ServiceProvider;

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
