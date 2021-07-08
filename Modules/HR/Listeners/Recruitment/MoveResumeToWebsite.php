<?php

namespace Modules\HR\Listeners\Recruitment;

use Illuminate\Support\Facades\Artisan;
use Modules\HR\Events\Recruitment\ApplicationCreated;

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
