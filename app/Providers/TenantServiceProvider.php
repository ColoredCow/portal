<?php

namespace App\Providers;

use App\Services\TenantService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->environment('testing')) {
            \Tenant::setUpDBConnection();
        }

        if (Schema::hasTable('organizations')) {
            \Tenant::setUpDBConnection();
        }
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
