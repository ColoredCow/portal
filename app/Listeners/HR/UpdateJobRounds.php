<?php

namespace App\Listeners\HR;

use App\Events\HR\JobUpdated;

class UpdateJobRounds
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
     * @param  JobUpdated  $event
     * @return void
     */
    public function handle(JobUpdated $event)
    {
        if (! array_key_exists('rounds', $event->attr)) {
            return;
        }

        $event->job->rounds()->sync($event->attr['rounds'], false);
    }
}
