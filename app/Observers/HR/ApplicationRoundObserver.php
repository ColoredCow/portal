<?php

namespace App\Observers\HR;

use App\Models\HR\ApplicationRound;
use App\Notifications\HR\ApplicationRoundScheduled;
use App\Services\CalendarService;

class ApplicationRoundObserver
{
    /**
     * Listen to the ApplicationRound created event.
     *
     * @param  \App\Models\HR\ApplicationRound  $applicationRound
     * @return void
     */
    public function created(ApplicationRound $applicationRound)
    {
        $applicationRound->load('application', 'scheduledPerson');
        if ($applicationRound->application->status != config('constants.hr.status.on-hold.label')) {
            $applicationRound->scheduledPerson->notify(new ApplicationRoundScheduled($applicationRound));
        }

        if ($applicationRound->round->reminder_enabled) {
            self::createCalendarEvent($applicationRound);
        }
    }

    /**
     * Create the calendar event for the application round instance.
     *
     * @param  ApplicationRound $applicationRound
     */
    public function createCalendarEvent(ApplicationRound $applicationRound)
    {
        $applicant = $applicationRound->application->applicant;
        $calendar = new CalendarService();
        $event = $calendar->createEvent([
            'summary' => "Let's talk basics with ColoredCow – $applicant->name",
            'start' => $applicationRound->scheduled_date,
            'end' => $applicationRound->scheduled_date + 30,
            'attendees' => [
                'vaibhav@coloredcow.com',
            ],
        ]);

        dd($event);
    }
}
