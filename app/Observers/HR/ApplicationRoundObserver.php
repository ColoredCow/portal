<?php

namespace App\Observers\HR;

use App\Models\HR\ApplicationRound;
use App\Notifications\HR\ApplicationRoundScheduled;
use App\Services\CalendarService;
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
        $calendarService = new CalendarService();

        $eventDetails = [
            'summary' => "Let's talk basics with ColoredCow – $applicant->name",
            'start' => [
                'dateTime' => Carbon::parse($applicationRound->scheduled_date)->format(config('constants.calendar_datetime_format')),
                'timeZone' => config('app.timezone'),
            ],
            'end' => [
                'dateTime' => Carbon::parse($applicationRound->scheduled_date)->addMinutes(30)->format(config('constants.calendar_datetime_format')),
                'timeZone' => config('app.timezone'),
            ],
            'attendees' => [
                ['email' => $applicationRound->scheduledPerson->email],
                // ['email' => $applicant->email],
            ],
        ];
        $event = $calendarService->createEvent($eventDetails);
        dd($event);
    }
}
