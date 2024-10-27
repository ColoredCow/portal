<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Modules\User\Events\UserRemovedEvent' => [
            'App\Listeners\RemoveUserFromWebsite',
        ],
    ];
}
