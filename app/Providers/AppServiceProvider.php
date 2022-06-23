<?php

namespace App\Providers;

use App\Contracts\EmployeeServiceContract;
use App\Services\EmployeeService;
use Nwidart\Modules\Facades\Module;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupEnvForOldPackages();
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Module::macro('checkStatus', function ($moduleName) {
            return Module::has($moduleName) && Module::isEnabled($moduleName);
        });
        $this->loadService();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function setupEnvForOldPackages()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . config('constants.google_application_credentials'));
    }

    private function loadService()
    {
        if (! Arr::has($this->app->getBindings(), EmployeeServiceContract::class)) {
            $this->app->bind(EmployeeServiceContract::class, function () {
                return new EmployeeService();
            });
        }
    }
}
