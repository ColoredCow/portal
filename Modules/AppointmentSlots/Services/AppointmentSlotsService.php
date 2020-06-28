<?php

namespace Modules\AppointmentSlots\Services;

use Carbon\Carbon;
use App\Models\HR\Applicant;
use App\Models\HR\ApplicationRound;
use App\Services\CalendarEventService;
use App\Jobs\HR\SendApplicationRoundScheduled;
use Modules\AppointmentSlots\Entities\AppointmentSlot;
use Modules\Communication\Contracts\CalendarMeetingContract;
use Modules\AppointmentSlots\Contracts\AppointmentSlotsServiceContract;

class AppointmentSlotsService implements AppointmentSlotsServiceContract
{
    public function showAppointments($data, $params)
    {
        $decryptedParams = json_decode(decrypt($params), true);
        $userId = $decryptedParams['user_id'];

        if (!$this->isAppointmentSlotField($userId)) {
            $this->fillScheduleForTheDay($userId);
        }

        $freeSlots = AppointmentSlot::user($userId)->free()->get();

        $freeSlots = $this->formatForFullCalender($freeSlots);

        return ['freeSlots' => $freeSlots, 'params' => $params];
    }

    public function appointmentSelected($data)
    {
        $email = $data['email'];
        $slotID = $data['slot_id'];
        $params = json_decode(decrypt($data['params']), true);

        $applicationRound = ApplicationRound::find($params['application_round_id']);

        $applicant = Applicant::where('email', $email)->first();
        if (!$applicant) {
            return ['error' => true, 'message' => 'invalid email id'];
        }

        $appointmentSlot = AppointmentSlot::find($slotID);
        $appointmentSlot->status = 'reserved';
        $appointmentSlot->reserved_for_id = $applicant->id;
        $appointmentSlot->reserved_for_type = get_class($applicant);
        $appointmentSlot->save();

        $applicationRound->scheduled_date = $appointmentSlot->start_time;
        $applicationRound->scheduled_end = $appointmentSlot->start_time;
        $applicationRound->save();

        $this->schedule($applicationRound, ['applicant_email' => $email]);
        SendApplicationRoundScheduled::dispatch($applicationRound);

        return ['error' => false, 'message' => ''];
    }

    private function isAppointmentSlotField($userId)
    {
        return AppointmentSlot::whereBetween('start_time', [Carbon::today(), Carbon::tomorrow()])
                ->where('user_id', $userId)
                ->first();
    }

    private function fillScheduleForTheDay($userId)
    {
        $startDate = Carbon::createFromTimeString('11:00:00');
        $slots = [];
        $numberOfSlots = 6;

        for ($j = 0; $j < 20; $j++) {
            $nextDay = (clone $startDate)->addDays(1);
            for ($i = 0; $i < $numberOfSlots; $i++) {
                $slots[] = [
                                'user_id' => $userId,
                                'start_time' => (clone $startDate),
                                'end_time' => (clone $startDate)->addMinutes(30),
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                $startDate->addMinutes(30);
            }

            $startDate = $nextDay;
        }

        return AppointmentSlot::insert($slots);
    }

    private function createCalendarEvent(ApplicationRound $applicationRound)
    {
        $applicant = $applicationRound->application->applicant;
        $summary = 'Appointment Scheduled';

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

    public function schedule(ApplicationRound $applicationRound, $data)
    {
        $summery = 'Appointment Scheduled';
        $guests = [['email' => $data['applicant_email'], 'responseStatus' => 'accepted']];

        $calendarMeetingService = app(CalendarMeetingContract::class);
        $calendarMeetingService->setOrganizer($applicationRound->scheduledPerson);

        $calendarMeetingService->createNewMeeting([
            'summary' => $summery,
            'start' => $applicationRound->scheduled_date,
            'end' => $applicationRound->scheduled_end,
            'attendees' => $guests,
        ]);

        $applicationRound->update([
            'calendar_event' => $calendarMeetingService->getEvent()->id,
        ]);
        return true;
    }

    private function formatForFullCalender($slots)
    {
        $results = [];
        foreach ($slots as $slot) {
            $results[] = [
                'title' => 'Meeting',
                'start' => $slot->start_time,
                'end' => $slot->end_time,
                'id' => $slot->id
            ];
        }

        return $results;
    }
}
