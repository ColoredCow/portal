<?php

namespace App\Providers;

use App\Models\HR\ApplicationMeta;
use App\Models\HR\ApplicationRound;
use App\Models\HR\Employee;
use App\Observers\HR\ApplicationMetaObserver;
use App\Observers\HR\ApplicationRoundObserver;
use App\Observers\HR\EmployeeObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Modules\User\Entities\User;

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
        ApplicationMeta::observe(ApplicationMetaObserver::class);
        User::observe(UserObserver::class);
        Employee::observe(EmployeeObserver::class);
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
