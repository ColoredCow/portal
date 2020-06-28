<?php

namespace Modules\HR\Listeners;

use Modules\HR\Events\ApplicationMovedToNewRound;
use Modules\HR\Notifications\SelectAppointmentSlotNotification;

class NotifyApplicantToSelectSlot
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
     * @param  object  $event
     * @return void
     */
    public function handle(ApplicationMovedToNewRound $event)
    {
        $applicationRound = $event->applicationRound;
        $applicant = $applicationRound->application->applicant;
        $applicant->notify(new SelectAppointmentSlotNotification($applicationRound));
    }
}
