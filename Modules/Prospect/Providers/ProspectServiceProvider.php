<?php

namespace Modules\Prospect\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Prospect\Contracts\ProspectChecklistServiceContract;
use Modules\Prospect\Contracts\ProspectHistoryServiceContract;
use Modules\Prospect\Contracts\ProspectMeetingServiceContract;
use Modules\Prospect\Contracts\ProspectServiceContract;
use Modules\Prospect\Services\ProspectChecklistService;
use Modules\Prospect\Services\ProspectHistoryService;
use Modules\Prospect\Services\ProspectMeetingService;
use Modules\Prospect\Services\ProspectService;

class ProspectServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'Prospect';

    /**
     * @var string
     */
    protected $moduleNameLower = 'prospect';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->loadService();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path($this->moduleName, 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }

        return $paths;
    }

    private function loadService()
    {
        if (! Arr::has($this->app->getBindings(), ProspectServiceContract::class)) {
            $this->app->bind(ProspectServiceContract::class, function () {
                return new ProspectService();
            });
        }

        if (! Arr::has($this->app->getBindings(), ProspectHistoryServiceContract::class)) {
            $this->app->bind(ProspectHistoryServiceContract::class, function () {
                return new ProspectHistoryService();
            });
        }

        if (! Arr::has($this->app->getBindings(), ProspectChecklistServiceContract::class)) {
            $this->app->bind(ProspectChecklistServiceContract::class, function () {
                return new ProspectChecklistService();
            });
        }

        if (! Arr::has($this->app->getBindings(), ProspectMeetingServiceContract::class)) {
            $this->app->bind(ProspectMeetingServiceContract::class, function () {
                return new ProspectMeetingService();
            });
        }
    }
}
