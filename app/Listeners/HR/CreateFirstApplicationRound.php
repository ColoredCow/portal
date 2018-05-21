<?php

namespace App\Listeners\HR;

use App\Events\HR\ApplicationCreated;
use App\Models\HR\ApplicationRound;
use App\User;
use Carbon\Carbon;
use App\Notifications\HR\ApplicationRoundScheduled;

class CreateFirstApplicationRound
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
        $application = $event->application;

        $job = $application->job;

        $scheduledPerson = User::findByEmail($job->postedBy);
        $scheduledPerson = $scheduledPerson ?? User::find(config('constants.hr.defaults.scheduled_person_id'));

        $applicationRound = ApplicationRound::_create([
            'hr_application_id' => $application->id,
            'hr_round_id' => $job->rounds->first()->id,
            'scheduled_date' => Carbon::now()->addDay(),
            'scheduled_person_id' => $scheduledPerson->id,
        ]);

        $scheduledPerson->notify(new ApplicationRoundScheduled($applicationRound));
    }
}
