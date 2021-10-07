<?php

namespace Modules\AppointmentSlots\Observers;

use Carbon\Carbon;
use Modules\AppointmentSlots\Entities\AppointmentSlot;

class UserAppointmentSlotObserver
{
    /**
     * Listen to the AppointmentSlot create event.
     * @param  AppointmentSlot $userAppointmentSlot
     * @return void
     */
    public function created(AppointmentSlot $userAppointmentSlot)
    {
        if (! $userAppointmentSlot->parent()->exists()) {
            $startTime = $userAppointmentSlot->start_time;
            $endTime = $userAppointmentSlot->end_time;
            $repeatTill = new Carbon(request('repeat_till'));
            $repeatTill = $repeatTill->addDay();
            $userId = request('user_id');
            $duration = '';

            switch ($userAppointmentSlot->recurrence) {
                case 'daily':
                    $noOfSlots = $endTime->diffInDays($repeatTill);
                    $duration = 'addDay';
                    break;
                case 'weekly':
                    $noOfSlots = $endTime->diffInWeeks($repeatTill);
                    $duration = 'addWeek';
                    break;
                case 'monthly':
                    $noOfSlots = $endTime->diffInMonths($repeatTill);
                    $duration = 'addMonth';
                    break;
                default:
                    $noOfSlots = 0;
            }
            while ($noOfSlots--) {
                $startTime->{$duration}();
                $endTime->{$duration}();
                $userAppointmentSlot->children()->create([
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'user_id' => $userId,
                    'recurrence' => $userAppointmentSlot->recurrence,
                ]);
            }
        }
    }
}
