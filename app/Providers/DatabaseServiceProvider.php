<?php

namespace App\Providers;

use App\Models\HR\ApplicationMeta;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Employee;
use App\Models\HR\Job;
use App\Models\HR\Slot;
use App\Observers\HR\ApplicationMetaObserver;
use App\Observers\HR\ApplicationRoundObserver;
use App\Observers\HR\EmployeeObserver;
use App\Observers\HR\JobObserver;
use App\Observers\UserObserver;
use App\Observers\HR\SlotObserver;
use Modules\User\Entities\User;
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
        Slot::observe(SlotObserver::class);
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
