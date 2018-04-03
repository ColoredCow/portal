<?php

namespace App\Listeners\HR;

use App\Events\HR\JobCreated;

class CreateJobRounds
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
     * @param  JobCreated  $event
     * @return void
     */
    public function handle(JobCreated $event)
    {
        $event->job->rounds()->attach(Round::all()->pluck('id')->toArray());
    }
}
