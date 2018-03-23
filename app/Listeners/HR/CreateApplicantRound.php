<?php

namespace App\Listeners\HR;

use App\Events\HR\ApplicantCreated;
use App\Models\HR\ApplicantRound;
use App\Models\HR\Job;
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

        $applicant_round = ApplicantRound::_create([
            'hr_applicant_id' => $applicant->id,
            'hr_round_id' => $job->rounds->first()->id,
            'scheduled_date' => Carbon::now()->addDay(),
            'scheduled_person_id' => 1,
        ]);
    }
}
