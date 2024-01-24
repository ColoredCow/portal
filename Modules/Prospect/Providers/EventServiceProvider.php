<?php

namespace Modules\Prospect\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Prospect\Events\NewProspectHistoryEvent;
use Modules\Prospect\Listeners\CreateProspectHistoryListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewProspectHistoryEvent::class => [
            CreateProspectHistoryListener::class,
        ],
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
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
}
