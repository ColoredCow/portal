<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\HR\ApplicationRound::observe(\App\Observers\HR\ApplicationRoundObserver::class);
        \App\Models\HR\Job::observe(\App\Observers\HR\JobObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
