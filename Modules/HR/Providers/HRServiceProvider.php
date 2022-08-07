<?php

namespace Modules\HR\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\HR\Contracts\ApplicationServiceContract;
use Modules\HR\Contracts\UniversityServiceContract;
use Modules\HR\Entities\ApplicationMeta;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Entities\Employee;
use Modules\HR\Entities\Job;
use Modules\HR\Entities\Applicant;
use Modules\HR\Observers\EmployeeObserver;
use Modules\HR\Observers\Recruitment\ApplicationMetaObserver;
use Modules\HR\Observers\Recruitment\ApplicationRoundObserver;
use Modules\HR\Observers\Recruitment\ApplicantObserver;
use Modules\HR\Observers\Recruitment\JobObserver;
use Modules\HR\Services\ApplicationService;
use Modules\HR\Services\UniversityService;

class HRServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'HR';

    /**
     * @var string
     */
    protected $moduleNameLower = 'hr';

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
        $this->registerCommands();
        $this->registerObservers();
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
        $this->app->register(HRAuthServiceProvider::class);
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
            $sourcePath => $viewPath
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
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang/en'), $this->moduleNameLower);
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
        if (! Arr::has($this->app->getBindings(), ApplicationServiceContract::class)) {
            $this->app->bind(ApplicationServiceContract::class, function () {
                return new ApplicationService();
            });
        }
        if (! Arr::has($this->app->getBindings(), UniversityServiceContract::class)) {
            $this->app->bind(UniversityServiceContract::class, function () {
                return new UniversityService();
            });
        }
    }

    /**
     * Register the commands for the module.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands([
            \Modules\HR\Console\Recruitment\DailyMessage::class,
            \Modules\HR\Console\Recruitment\ApplicationNoShow::class,
            \Modules\HR\Console\Recruitment\MappingOfJobsAndHrRounds::class,
            \Modules\HR\Console\Recruitment\MarkApplicationForFollowUp::class,
            \Modules\HR\Console\Recruitment\MoveFilesToWordPress::class,
            \Modules\HR\Console\Recruitment\ResetIsLatestApplicationRound::class,
            \Modules\HR\Console\Recruitment\SendInterviewReminders::class,
            \Modules\HR\Console\Recruitment\sendFollowUpThresholdMail::class,
        ]);
    }

    /**
     * Register the observers for the module.
     *
     * @return void
     */
    protected function registerObservers()
    {
        Job::observe(JobObserver::class);
        ApplicationRound::observe(ApplicationRoundObserver::class);
        ApplicationMeta::observe(ApplicationMetaObserver::class);
        Employee::observe(EmployeeObserver::class);
        Applicant::observe(ApplicantObserver::class);
    }
}
