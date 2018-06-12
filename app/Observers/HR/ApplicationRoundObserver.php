<?php

namespace App\Observers\HR;

use App\Jobs\HR\SendApplicationRoundScheduled;
use App\Models\HR\ApplicationRound;
use App\Services\CalendarEventService;

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
            SendApplicationRoundScheduled::dispatch($applicationRound);
        }

        if (request()->get('create_calendar_event')) {
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
        $summary = request()->get('summary_calendar_event');

        $event = new CalendarEventService;
        $event->create([
            'summary' => $summary,
            'start' => $applicationRound->scheduled_date,
            'end' => $applicationRound->scheduled_end,
            'attendees' => [
                $applicationRound->scheduledPerson->email,
                $applicant->email,
            ],
        ]);

        $applicationRound->update([
            'calendar_event' => $event->id,
        ]);
    }
}
