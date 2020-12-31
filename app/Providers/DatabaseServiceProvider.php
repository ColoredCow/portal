<?php

namespace App\Providers;

use App\Observers\HR\ApplicationMetaObserver;
use App\Observers\HR\ApplicationRoundObserver;
use App\Observers\HR\EmployeeObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Employee;
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
        User::observe(UserObserver::class);
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
