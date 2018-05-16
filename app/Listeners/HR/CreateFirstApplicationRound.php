<?php

namespace App\Listeners\HR;

use App\Events\HR\ApplicationCreated;
use App\Models\HR\ApplicationRound;
use App\User;
use Carbon\Carbon;

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
        $scheduledPerson = User::findByEmail($job->posted_by);

        $applicationRound = ApplicationRound::_create([
            'hr_applicant_id' => $application->applicant->id,
            'hr_application_id' => $application->id,
            'hr_round_id' => $job->rounds->first()->id,
            'scheduled_date' => Carbon::now()->addDay(),
            'scheduled_person_id' => $scheduledPerson ? $scheduledPerson->id : config('constants.hr.defaults.scheduled_person_id'),
        ]);
    }
}
