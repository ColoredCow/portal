<?php

namespace App\Providers;

use App\Models\HR\ApplicationMeta;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Job;
use App\Observers\HR\ApplicationMetaObserver;
use App\Observers\HR\ApplicationRoundObserver;
use App\Observers\HR\JobObserver;
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
        ApplicationRound::observe(ApplicationRoundObserver::class);
        Job::observe(JobObserver::class);
        ApplicationMeta::observe(ApplicationMetaObserver::class);
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
