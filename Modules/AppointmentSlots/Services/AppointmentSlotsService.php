<?php

namespace Modules\AppointmentSlots\Services;

use App\Services\CalendarEventService;
use Carbon\Carbon;
use Modules\AppointmentSlots\Contracts\AppointmentSlotsServiceContract;
use Modules\AppointmentSlots\Entities\AppointmentSlot;
use Modules\Communication\Contracts\CalendarMeetingContract;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Application;
use Modules\HR\Entities\ApplicationRound;
use Modules\HR\Jobs\Recruitment\SendApplicationRoundScheduled;
use Modules\User\Entities\UserMeta;

class AppointmentSlotsService implements AppointmentSlotsServiceContract
{
    // public function canSeeAppointments($data, $params)
    // {
    //     $decryptedParams = json_decode(decrypt($params), true);

    //     $applicationRound = null;
    //     if (isset($decryptedParams['application_id'])) {
    //         $applicationId = $decryptedParams['application_id'];
    //         $application = Application::find($applicationId);
    //         $applicationRound = $application->latestApplicationRound;
    //     } else {
    //         // old method. Kept for backward compatibility. Deprecated.
    //         $applicationRound = ApplicationRound::find($decryptedParams['application_round_id']);
    //     }

    //     if ($applicationRound && is_null($applicationRound->scheduled_date) && is_null($applicationRound->round_status)) {
    //         return true;
    //     }

    //     return false;
    // }

    public function showAppointments($params)
    {
        $decryptedParams = json_decode(decrypt($params), true);

        $userId = null;
        if (isset($decryptedParams['application_id'])) {
            $applicationId = $decryptedParams['application_id'];
            $application = Application::find($applicationId);
            $userId = $application->latestApplicationRound->scheduled_person_id;
            // if already rejected
            if ($application->isRejected() || $application->latestApplicationRound->scheduled_date) {
                return false;
            }
        } else {
            // old method. Kept for backward compatibility. Deprecated.
            $userId = $decryptedParams['user_id'];
        }

        $freeSlots = $this->getUserFreeSlots($userId);

        $freeSlotsThreshold = config('appointmentslots.recreate-threshold', 15);
        if ($freeSlots->count() < $freeSlotsThreshold) {
            if ($freeSlots->isEmpty()) {
                $this->createAppointmentSlots($userId);
            } else {
                // next day 11am from the last slot time
                $startDateTime = $freeSlots->last()->start_time->addDays(1)->setTime(11, 0);
                $this->createAppointmentSlots($userId, $startDateTime);
            }
            // refetch free slots after they're created
            $freeSlots = $this->getUserFreeSlots($userId);
        }

        $freeSlots = $this->formatForFullCalender($freeSlots);

        return ['freeSlots' => $freeSlots, 'params' => $params];
    }

    public function appointmentSelected($data)
    {
        $email = $data['email'];
        $applicant = Applicant::where('email', $email)->first();
        if (! $applicant) {
            return ['error' => true, 'message' => 'invalid email id'];
        }

        $slotId = $data['slot_id'];
        $params = json_decode(decrypt($data['params']), true);

        $applicationRound = null;
        if (isset($params['application_id'])) {
            $applicationId = $params['application_id'];
            $application = Application::find($applicationId);
            $applicationRound = $application->latestApplicationRound;
        } else {
            // old method. Kept for backward compatibility. Deprecated.
            $applicationRound = ApplicationRound::find($params['application_round_id']);
        }

        $appointmentSlot = AppointmentSlot::find($slotId);
        $appointmentSlot->status = 'reserved';
        $appointmentSlot->reserved_for_id = $applicant->id;
        $appointmentSlot->reserved_for_type = get_class($applicant);
        $appointmentSlot->save();

        $applicationRound->scheduled_date = $appointmentSlot->start_time;
        $applicationRound->scheduled_end = $appointmentSlot->end_time;
        $applicationRound->save();

        $this->schedule($applicationRound, ['applicant_email' => $email]);
        SendApplicationRoundScheduled::dispatch($applicationRound);

        $applicationRound->application->untag('need-follow-up');

        return ['error' => false, 'message' => ''];
    }

    public function createAppointmentSlots($userId, $startDate = null)
    {
        $startDate = $startDate ?: Carbon::createFromTimeString('11:00:00');

        $slots = $this->getSlotsForDays($userId, $startDate);

        foreach ($slots as $slot) {
            // skip for Saturday and Sunday
            if ($slot['start_time']->dayOfWeek == 0 || $slot['start_time']->dayOfWeek == 6) {
                continue;
            }
            // create appointment slot if doesn't exist for that time
            if (! AppointmentSlot::where('user_id', $userId)
                ->where('start_time', $slot['start_time'])
                ->exists()) {
                AppointmentSlot::insert($slot);
            }
        }
    }

    private function getSlotsForDays($userId, $startDate)
    {
        $slots = [];
        $maxSlotsDaily = config('hr.daily-appointment-slots.total', 6);
        $slotDuration = config('appointmentslots.slot-duration-minutes', 30);
        $createSlotsForDays = config('appointmentslots.auto-create-slots-for-days', 20);
        $gapBetweenSlots = config('appointmentslots.gap-between-slots-minutes', 15);

        for ($day = 0; $day < $createSlotsForDays; $day++) {
            $nextDay = (clone $startDate)->addDays(1);
            // for every day, create the appointment slots
            for ($slotCount = 0; $slotCount < $maxSlotsDaily; $slotCount++) {
                $slots[] = [
                    'user_id' => $userId,
                    'start_time' => (clone $startDate),
                    'end_time' => (clone $startDate)->addMinutes($slotDuration),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                // there should be 15-min gap between every slot.
                $startDate->addMinutes($slotDuration + $gapBetweenSlots);
            }

            // run the loop for next day now.
            $startDate = $nextDay;
        }

        return $slots;
    }

    public function schedule(ApplicationRound $applicationRound, $data)
    {
        $applicant = $applicationRound->application->applicant;
        $summary = "{$applicant->name} – {$applicationRound->round->name} with ColoredCow";
        $guests = [['email' => $data['applicant_email'], 'responseStatus' => 'accepted']];

        $calendarMeetingService = app(CalendarMeetingContract::class);
        $calendarMeetingService->setOrganizer($applicationRound->scheduledPerson);

        $calendarMeetingService->createNewMeeting([
            'summary' => $summary,
            'start' => $applicationRound->scheduled_date->format(config('constants.datetime_format')),
            'end' => $applicationRound->scheduled_end,
            'attendees' => $guests,
        ]);

        $applicationRound->update([
            'calendar_event' => $calendarMeetingService->getEvent()->id,
            'calendar_meeting_id' => $calendarMeetingService->calendarMeeting->id,
        ]);

        return true;
    }

    private function createCalendarEvent(ApplicationRound $applicationRound)
    {
        $applicant = $applicationRound->application->applicant;
        $summary = 'Appointment Scheduled';

        $event = new CalendarEventService;
        $event->create([
            'summary' => $summary,
            'start' => $applicationRound->scheduled_date->format(config('constants.datetime_format')),
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

    private function formatForFullCalender($slots)
    {
        $results = [];
        foreach ($slots as $slot) {
            $results[] = [
                'start' => $slot->start_time,
                'end' => $slot->end_time,
                'id' => $slot->id,
            ];
        }

        return $results;
    }

    /**
     * Get free slots for a user.
     *
     * @param  int  $userId
     */
    private function getUserFreeSlots($userId)
    {
        $slots = AppointmentSlot::user($userId)->future()->get();

        $reservedSlotsCount = $slots->where('status', 'reserved')->pluck('start_time')->countBy(function ($date) {
            return $date->format(config('constants.date_format', 'Y-m-d'));
        });

        $datesToRemove = $reservedSlotsCount->filter(function ($value) use ($userId) {
            $userMeta = UserMeta::where('user_id', $userId)->key('max_interviews_per_day')->first();
            $maxInterviewsPerDay = $userMeta ? $userMeta->meta_value : config('hr.daily-appointment-slots.max-reserved-allowed', 3);

            return $value >= $maxInterviewsPerDay;
        })->keys()->all();

        return $slots->where('status', 'free')->reject(function ($slot) use ($datesToRemove) {
            return in_array($slot->start_time->format(config('constants.date_format', 'Y-m-d')), $datesToRemove);
        });
    }
}
