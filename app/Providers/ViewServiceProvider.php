<?php

namespace App\Providers;

use App\Models\State;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer( ['project.components.billing-info'],  function($view) {
            return $view->with('states', State::orderBy('name')->get());
        });        
    }
}
