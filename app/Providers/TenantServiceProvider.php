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
        $this->app->singleton(TenantService::class, function ($app) {
            return new TenantService;
        });
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
