<?php
namespace OfficeSuite;

use Illuminate\Support\ServiceProvider;

class OfficeSuitesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('office_suite', function ($app) {
            return (new OfficeSuiteManager($app))->resolve();
        });

        // $this->app->singleton(OfficeSuiteService::class, function ($app) {
        //     return app('office_suite')->resolve();
        // });
    }
}
