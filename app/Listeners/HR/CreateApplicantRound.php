<?php

namespace App\Listeners\HR;

use App\Events\HR\ApplicantCreated;
use App\Models\HR\ApplicantRound;
use App\Models\HR\Job;
use App\User;
use Carbon\Carbon;

class CreateApplicantRound
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
     * @param  ApplicantCreated  $event
     * @return void
     */
    public function handle(ApplicantCreated $event)
    {
        $applicant = $event->applicant;

        $job = Job::find($applicant->hr_job_id)->first();

        $scheduled_person = User::findByEmail($job->posted_by);

        $applicant_round = ApplicantRound::_create([
            'hr_applicant_id' => $applicant->id,
            'hr_round_id' => $job->rounds->first()->id,
            'scheduled_date' => Carbon::now()->addDay(),
            'scheduled_person_id' => $scheduled_person ? $scheduled_person->id : config('constants.hr.defaults.scheduled_person_id'),
        ]);
    }
}
