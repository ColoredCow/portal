<?php

namespace App\Providers;

use App\Database\DBAL\TimestampType;
use Doctrine\DBAL\Types\Type;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
        if (Type::hasType('timestamp')) {
            Type::overrideType('timestamp', TimestampType::class);
        } else {
            Type::addType('timestamp', TimestampType::class);
        }
    }

    public function setupEnvForOldPackages()
    {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . config('constants.google_application_credentials'));
    }
}
