<?php

namespace App\Providers;

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
