<?php

namespace Modules\Prospect\Services;

use Modules\Communication\Contracts\CalendarMeetingContract;
use Modules\Prospect\Contracts\ProspectMeetingServiceContract;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectContactPerson;
use Modules\Prospect\Events\NewProspectHistoryEvent;

class ProspectMeetingService implements ProspectMeetingServiceContract
{
    public function schedule($data, $prospectID)
    {
        $prospect = Prospect::find($prospectID);
        $calendarMeetingService = app(CalendarMeetingContract::class);
        $calendarMeetingService->setOrganizer($prospect->assignTo);
        $guests = ProspectContactPerson::whereIn('id', $data['prospect_contact_persons'])
            ->pluck('email')
            ->toArray();
        $calendarMeetingService->createNewMeeting([
            'summary' => $data['meeting_summary'],
            'start' => $data['meeting_start_date'],
            'end' => $data['meeting_end_date'],
            'attendees' => $guests,
        ]);

        $calendarMeeting = $calendarMeetingService->getCalendarMeeting();
        $prospect->calendarMeetings()->attach([$calendarMeeting->id]);
        event(new NewProspectHistoryEvent($prospect, ['description' => 'New meeting schedule']));

        return true;
    }
}
