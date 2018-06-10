<?php

namespace App\Observers\HR;

use App\Models\HR\ApplicationRound;
use App\Notifications\HR\ApplicationRoundScheduled;
use App\Services\CalendarEventService;
use Carbon\Carbon;

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
        $roundStart = Carbon::parse($applicationRound->scheduled_date);

        $event = new CalendarEventService;
        $event->create([
            'summary' => "Let's talk basics with ColoredCow – $applicant->name",
            'start' => $roundStart->format(config('constants.datetime_format')),
            'end' => $roundStart->addMinutes(30)->format(config('constants.datetime_format')),
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
