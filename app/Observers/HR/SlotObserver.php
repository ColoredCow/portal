<?php

namespace App\Observers\HR;

use App\Models\HR\Slot;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SlotObserver
{
    /**
     * Listen to the ApplicationMeta create event
     * @param  ApplicationMeta $applicationMeta
     * @return void
     */
    public function created(Slot $slot)
    {
        if (!$slot->parent()->exists()) {
            $startsAt=Carbon::parse($slot->starts_at);
            $endsAt=Carbon::parse($slot->ends_at);
            $repeatTill=Carbon::parse(request('repeat_till'));
            
            switch ($slot->recurrence) {
                case 'weekly':
                    $noOfSlots=$startsAt->diffInWeeks($repeatTill);
                    $duration='addWeek';
                break;
                case 'monthly':
                    $noOfSlots=$startsAt->diffInMonths($repeatTill);
                    $duration='addMonth';
                break;
                default:
                    $noOfSlots=0;
            }
            for ($i = 0; $i < $noOfSlots; $i++) {
                $startsAt->{$duration}();
                $endsAt->{$duration}();
                $slot->children()->create([
                            'starts_at'    => $startsAt,
                            'ends_at'      => $endsAt,
                            'user_id'=>auth()->id(),
                            'recurrence'    =>$slot->recurrence,
                        ]);
            }
        }
    }
}
