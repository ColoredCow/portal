<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\HR\ApplicationCreated' => [
            'App\Listeners\HR\CreateFirstApplicationRound',
            'App\Listeners\HR\AutoRespondApplicant',
            'App\Listeners\HR\MoveResumeToWebsite',
        ],
        'App\Events\HR\JobUpdated' => [
            'App\Listeners\HR\UpdateJobRounds',
        ],

        'Modules\User\Events\UserRemovedEvent' => [
            'App\Listeners\RemoveUserFromWebsite'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
