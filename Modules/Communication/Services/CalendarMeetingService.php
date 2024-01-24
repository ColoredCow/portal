<?php

namespace Modules\Communication\Services;

use Carbon\Carbon;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Auth;
use Modules\Communication\Contracts\CalendarMeetingContract;
use Modules\Communication\Entities\CalendarMeeting;

class CalendarMeetingService implements CalendarMeetingContract
{
    public $id;
    public $calendarMeeting = null;
    protected $attendees = [];
    protected $summary;
    protected $startDateTime;
    protected $endDateTime;
    protected $hangoutLink;
    protected $service;
    protected $isDetailsSet = false;
    protected $organizer = null;
    protected $event;

    public function __construct($organizer = null, $details = [])
    {
        if ($organizer) {
            $this->setOrganizer($organizer);
        }
        if ($details) {
            $this->setData($details);
        }
        $this->setClient();
    }

    public function setDetails($details)
    {
        if (! isset($details['summary'], $details['attendees'], $details['start'], $details['end'])) {
            throw new Exception('Invalid data for calendar creation');
        }

        $this->setSummary($details['summary']);
        $this->setAttendees($details['attendees']);
        $this->setStartDateTime($details['start']);
        $this->setEndDateTime($details['end']);
        $this->isDetailsSet = true;
    }

    public function setClient()
    {
        $client = new Google_Client();
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $client->useApplicationDefaultCredentials();
        $client->setApprovalPrompt('force');
        if ($this->organizer) {
            $client->setSubject($this->organizer->email);
        } else {
            $client->setSubject(config('constants.gsuite.service-account-impersonate'));
        }

        $this->service = new Google_Service_Calendar($client);
    }

    public function setOrganizer($organizer)
    {
        $this->organizer = $organizer;
        $this->setClient();
    }

    public function createNewMeeting(array $details = [], $calendarId = 'primary')
    {
        if ($details) {
            $this->setDetails($details);
        }

        if (! $this->isDetailsSet) {
            throw new Exception('You need to provide details first.');
        }

        $event = new Google_Service_Calendar_Event([
            'summary' => $this->summary,
            'attendees' => $this->attendees,
            'start' => $this->startDateTime,
            'end' => $this->endDateTime,
            'conferenceDataVersion' => 1,
        ]);

        $event->setConferenceData(new Google_Service_Calendar_ConferenceData([
                'createRequest' => [
                    'requestId' => md5(time()),  // @phpstan-ignore-line
                    'conferenceSolutionKey' => [
                        'type' => 'hangoutsMeet',
                    ],
                ],
        ]));

        $options = [
            'sendNotifications' => true,
            'conferenceDataVersion' => 1,
        ];

        $event = $this->service->events->insert($calendarId, $event, $options);
        $this->id = $event->id;
        $this->setEvent($event);
        $this->setHangoutLink($event->hangoutLink);
        $this->addNewMeetingToDB();
    }

    public function fetch($eventId, $calendarId = 'primary')
    {
        $event = $this->service->events->get($calendarId, $eventId);
        $this->setSummary($event->summary);

        $attendees = [];
        foreach ($event->attendees as $attendee) {
            array_push($attendees, $attendee->email);
        }
        $this->setAttendees($attendees);
        $this->setHangoutLink($event->hangoutLink);
        $this->setStartDateTime($event->start->dateTime, $event->start->timeZone);
        $this->setEndDateTime($event->end->dateTime, $event->end->timeZone);
        $this->id = $eventId;
    }

    public function getHangoutLink()
    {
        return $this->hangoutLink;
    }

    public function setHangoutLink($hangoutLink)
    {
        $this->hangoutLink = $hangoutLink;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    public function getAttendees()
    {
        $attendees = [];
        foreach ($this->attendees as $attendee) {
            array_push($attendees, $attendee['email']);
        }

        return $attendees;
    }

    public function setAttendees(array $attendees)
    {
        foreach ($attendees as $attendee) {
            if (is_array($attendee)) {
                $this->attendees[] = $attendee;
                continue;
            }

            $this->attendees[] = [
                'email' => $attendee,
            ];
        }
    }

    public function getStartDateTime($withTimeZone = false)
    {
        return self::getDateTime($this->startDateTime, $withTimeZone);
    }

    public function setStartDateTime($dateTime, $timeZone = null)
    {
        $this->startDateTime = self::getCalendarDateTime($dateTime, $timeZone);
    }

    public function getEndDateTime($timeZone = false)
    {
        return self::getDateTime($this->endDateTime, $timeZone);
    }

    public function setEndDateTime($dateTime, $timeZone = null)
    {
        $this->endDateTime = self::getCalendarDateTime($dateTime, $timeZone);
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getCalendarMeeting()
    {
        return $this->calendarMeeting;
    }

    /**
     * Returns an array that is expected by the Google Calendar API.
     *
     * @param  string $dateTime
     * @param  string $timeZone
     *
     * @return array
     */
    protected static function getCalendarDateTime($dateTime, $timeZone)
    {
        $timeZone = $timeZone ?? config('app.timezone');

        return [
            'dateTime' => Carbon::parse($dateTime)->format(config('constants.calendar_datetime_format')),
            'timeZone' => $timeZone,
        ];
    }

    /**
     * Returns an array with formats expected by Portal modules.
     *
     * @param  mixed $eventDateTime
     * @param  bool $withTimeZone    defines whether to return the calendar event timeZone or not
     *
     * @return array
     */
    protected static function getDateTime($eventDateTime, $withTimeZone)
    {
        $results = [];
        $results['dateTime'] = Carbon::parse($eventDateTime['dateTime'])->format(config('constants.datetime_format'));

        if ($withTimeZone) {
            $results['timeZone'] = $eventDateTime['timeZone'];
        }

        return $results;
    }

    private function setEvent($event)
    {
        $this->event = $event;
    }

    private function addNewMeetingToDB()
    {
        $calendarMeeting = new CalendarMeeting();
        $calendarMeeting->created_by = Auth::id();
        $calendarMeeting->organizer_id = optional($this->organizer)->id;
        $calendarMeeting->attendees = $this->attendees;
        $calendarMeeting->event_title = $this->summary;
        $calendarMeeting->start_at = $this->startDateTime['dateTime'];
        $calendarMeeting->ends_at = $this->endDateTime['dateTime'];
        $calendarMeeting->calendar_event = $this->id;
        $calendarMeeting->hangout_link = $this->getHangoutLink();
        $calendarMeeting->save();
        $this->calendarMeeting = $calendarMeeting;
    }
}
