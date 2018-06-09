<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class CalendarService
{
    protected $service;

    public function __construct()
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(config('constants.gsuite.service-account-impersonate'));
        $client->setScopes(Google_Service_Calendar::CALENDAR);
        $this->service = new Google_Service_Calendar($client);
    }

    public function createEvent($eventDetails, $calendarId = 'primary')
    {
        $event = new Google_Service_Calendar_Event($eventDetails);
        return $this->service->events->insert($calendarId, $event);
    }
}
