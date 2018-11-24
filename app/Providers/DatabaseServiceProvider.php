<?php

namespace App\Providers;

use App\Models\HR\ApplicationMeta;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Employee;
use App\Models\HR\Job;
use App\Observers\HR\ApplicationMetaObserver;
use App\Observers\HR\ApplicationRoundObserver;
use App\Observers\HR\EmployeeObserver;
use App\Observers\HR\JobObserver;
use App\Observers\HR\OnboardObserver;
use App\Observers\UserObserver;
use App\Services\GSuiteUserService;
use App\User;
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
        User::observe(UserObserver::class);
        Employee::observe(EmployeeObserver::class);
        GsuiteUserService::observe(OnboardObserver::class);
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
