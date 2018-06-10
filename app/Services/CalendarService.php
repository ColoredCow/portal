<?php

namespace App\Services;

use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class CalendarService
{
    protected $attendees = [];
    protected $eventSummary;
    protected $eventStart;
    protected $eventEnd;
    protected $eventHangoutLink;
    protected $service;

    public function __construct()
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(config('constants.gsuite.service-account-impersonate'));
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $this->service = new Google_Service_Calendar($client);
    }

    public function createEvent($details, $calendarId = 'primary')
    {
        if (!isset($details['summary'], $details['attendees'], $details['start'])) {
            throw new Exception('Invalid data for calendar creation');
        }

        $this->setEventSummary($details['summary']);
        $this->setAttendees($details['attendees']);
        $this->setEventStart($details['start']);
        if (isset($details['end'])) {
            $this->setEventEnd($details['end']);
        }

        $event = new Google_Service_Calendar_Event([
            'summary' => $this->eventSummary,
            'attendees' => $this->attendees,
            'start' => $this->eventStart,
            'end' => $this->eventEnd,
        ]);
        $event = $this->service->events->insert($calendarId, $event);
        $this->setEventHangoutLink($event->hangoutLink);
        dd($event);
    }

    public function getEvent($eventId, $calendarId = 'primary')
    {
        $event = $this->service->events->get($calendarId, $eventId);
        $this->setEventSummary($event->summary);

        $attendees = [];
        foreach ($event->attendees as $attendee) {
            array_push($attendees, $attendee->email);
        }
        $this->setAttendees($attendees);
        $this->setEventHangoutLink($event->hangoutLink);
        $this->setEventStart($event->start->dateTime, $event->start->timeZone);
        $this->setEventEnd($event->end->dateTime, $event->end->timeZone);

        return $this;
    }

    public function getEventHangoutLink()
    {
        return $this->eventHangoutLink;
    }

    public function setEventHangoutLink($hangoutLink)
    {
        $this->eventHangoutLink = $hangoutLink;
    }

    public function getEventSummary()
    {
        return $this->eventSummary;
    }

    public function setEventSummary($summary)
    {
        $this->eventSummary = $summary;
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

    /**
     * Returns an array that is expected by the Google Calendar API
     * @param  string $dateTime
     * @param  string $timeZone
     *
     * @return array
     */
    protected static function getCalendarEventDateTime($dateTime, $timeZone)
    {
        $timeZone = $timeZone ?? config('app.timezone');
        return [
            'dateTime' => Carbon::parse($dateTime)->format(config('constants.calendar_datetime_format')),
            'timeZone' => $timeZone,
        ];
    }

    /**
     * Returns an array with formats expected by Employee Portal modules
     *
     * @param  string $eventDateTime
     * @param  boolean $withTimeZone    defines whether to return the calendar event timeZone or not
     *
     * @return array
     */
    protected static function getEventDateTime($eventDateTime, $withTimeZone)
    {
        $dateTime['dateTime'] = Carbon::parse($eventDateTime['dateTime'])->format(config('constants.datetime_format'));
        if ($withTimeZone) {
            $start['timeZone'] = $eventDateTime['timeZone'];
        }
        return $dateTime;
    }

    public function getEventStart($withTimeZone = false)
    {
        return self::getEventDateTime($this->eventStart);
    }

    public function setEventStart($dateTime, $timeZone = null)
    {
        $this->eventStart = self::getCalendarEventDateTime($dateTime, $timeZone);
    }

    public function getEventEnd($timeZone = false)
    {
        return self::getEventDateTime($this->eventEnd);
    }

    public function setEventEnd($dateTime, $timeZone = null)
    {
        $this->eventEnd = self::getCalendarEventDateTime($dateTime, $timeZone);
    }
}
