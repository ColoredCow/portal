<?php
namespace App\Providers;

use App\Http\View\Composers\CodeTrekApplicantsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ApplicantsComposerServiceProvider extends ServiceProvider
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
        View::composer('*', CodeTrekApplicantsComposer::class);
    }
}
