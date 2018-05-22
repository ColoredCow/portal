<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\HR\ApplicationRound;
use App\Observers\HR\ApplicationRoundObserver;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        ApplicationRound::observe(ApplicationRoundObserver::class);
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
