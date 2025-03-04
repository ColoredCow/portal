<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class CalendarEventService
{
    protected $attendees = [];
    protected $summary;
    protected $startDateTime;
    protected $endDateTime;
    protected $hangoutLink;
    protected $service;
    protected $id;
    protected $description;

    public function __construct()
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(config('constants.gsuite.service-account-impersonate'));
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $this->service = new Google_Service_Calendar($client);
    }

    public function create($details, $calendarId = 'primary')
    {
        if (! isset($details['summary'], $details['attendees'], $details['start'], $details['end'])) {
            throw new Exception('Invalid data for calendar creation');
        }

        $this->setSummary($details['summary']);
        $this->setAttendees($details['attendees']);
        $this->setStartDateTime($details['start']);
        $this->setEndDateTime($details['end']);
        $this->setDescription($details['description']);

        $event = new Google_Service_Calendar_Event([
            'summary' => $this->summary,
            'attendees' => $this->attendees,
            'start' => $this->startDateTime,
            'end' => $this->endDateTime,
            'description' => $this->description,
        ]);

        $optprm = [
            'sendNotifications' => true,
        ];
        $event = $this->service->events->insert($calendarId, $event, $optprm);
        $this->id = $event->id;
        $this->setHangoutLink($event->hangoutLink);
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
        $this->setDescription($event->description);
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

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription($description)
    {
        $this->description = $description;
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

    /**
     * Returns an array that is expected by the Google Calendar API.
     *
     * @param string $dateTime
     * @param string $timeZone
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
     * @param mixed $eventDateTime
     * @param bool  $withTimeZone  defines whether to return the calendar event timeZone or not
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
}
