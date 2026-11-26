<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;

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

        // Laravel 13 dropped the implicit redirect to route('login') for
        // unauthenticated web requests (it now returns 401). Restore it; JSON
        // requests still get 401 because the handler checks that first.
        Authenticate::redirectUsing(fn (Request $request) => route('login'));
        Module::macro('checkStatus', function ($moduleName) {
            return Module::has($moduleName) && Module::isEnabled($moduleName);
        });
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
}
