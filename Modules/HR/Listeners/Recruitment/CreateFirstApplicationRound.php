<?php

namespace Modules\HR\Listeners\Recruitment;

use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Events\Recruitment\ApplicationCreated;
use Modules\User\Entities\User;

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
     *
     * @return void
     */
    public function handle(ApplicationCreated $event)
    {
        $application = $event->application;

        $job = $application->job;

        $defaultAssignee = $job->rounds->first()->pivot->hr_round_interviewer_id;
        $scheduledPerson = null;

        if ($defaultAssignee) {
            $scheduledPerson = User::find($defaultAssignee);
        }

        $scheduledPerson = $scheduledPerson ?: User::find(config('hr.defaults.scheduled_person_id'));

        ApplicationRound::create([
            'hr_application_id' => $application->id,
            'hr_round_id' => $job->rounds->first()->id,
            'scheduled_date' => now()->addDay(),
            'scheduled_person_id' => $scheduledPerson->id,
        ]);
    }
}
