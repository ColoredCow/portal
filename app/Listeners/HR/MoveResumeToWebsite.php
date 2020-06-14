<?php

namespace App\Listeners\HR;

use App\Events\HR\ApplicationCreated;
use Illuminate\Support\Facades\Artisan;

class MoveResumeToWebsite
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ApplicationCreated  $event
     * @return void
     */
    public function handle(ApplicationCreated $event)
    {
        Artisan::call('hr:move-resume-to-website');
    }
}
