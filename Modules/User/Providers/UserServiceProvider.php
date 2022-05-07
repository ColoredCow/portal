<?php

namespace Modules\User\Providers;

use Exception;
use Illuminate\Support\Arr;
use Modules\User\Entities\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use Modules\User\Policies\RolePolicy;
use Modules\User\Policies\UserPolicy;
use Modules\User\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\User\Services\ProfileService;
use Modules\User\Services\ExtendUserModel;
use Modules\User\Contracts\UserServiceContract;
use Modules\User\Contracts\ProfileServiceContract;

class UserServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $moduleName = 'User';

    /**
     * @var string
     */
    protected $moduleNameLower = 'user';

    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
    ];

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
        $this->registerPolicies();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        $this->registerExtendableClass();
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

    /**
     * Register the module's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    private function registerExtendableClass()
    {
        $this->app->singleton('USER_EXTENDED', function ($app, $data) {
            $class = config('user.extended_class');
            if (! class_exists($class)) {
                return;
            }

            if (! is_subclass_of($class, ExtendUserModel::class)) {
                throw new Exception('User module extension class must extend ' . ExtendUserModel::class);
            }

            $extendedClass = new $class();
            $extendedClass->setModelContext($data['context']);

            return $extendedClass;
        });
    }

    private function loadService()
    {
        if (! Arr::has($this->app->getBindings(), UserServiceContract::class)) {
            $this->app->bind(UserServiceContract::class, function () {
                return new UserService();
            });
        }

        if (! Arr::has($this->app->getBindings(), ProfileServiceContract::class)) {
            $this->app->bind(ProfileServiceContract::class, function () {
                return new ProfileService();
            });
        }
    }
}
