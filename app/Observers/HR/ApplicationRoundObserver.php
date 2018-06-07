<?php

namespace App\Observers\HR;

use App\Models\HR\ApplicationRound;
use App\Notifications\HR\ApplicationRoundScheduled;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

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
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(env('GOOGLE_SERVICE_ACCOUNT_IMPERSONATE'));
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $service = new Google_Service_Calendar($client);

        $applicant = $applicationRound->application->applicant;
        $event = new Google_Service_Calendar_Event([
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
            ],
        ]);

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        dd($event);
    }
}
