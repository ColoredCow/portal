<?php

namespace App\Providers;

use Nwidart\Modules\Facades\Module;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Modules\CodeTrek\Entities\CodeTrekFeedbackCategories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('feedback_categories', CodeTrekFeedbackCategories::all());
        $this->setupEnvForOldPackages();
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
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
