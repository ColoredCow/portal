<?php

namespace App\Observers\HR;

use App\Models\HR\Slots;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecurrenceObserver
{
    /**
     * Listen to the ApplicationMeta create event
     * @param  ApplicationMeta $applicationMeta
     * @return void
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function created(Slots $slot)
    {
        if (!$slot->slot()->exists()) {
            $request=$this->request;
            $start_time=Carbon::parse($slot->starts_at);
            $end_time=Carbon::parse($slot->ends_at);
            $repeat_till=Carbon::parse(request('repeat_till'));
            
            switch (request('recurrence')) {
                case 'weekly':
                    $no_of_slots=$start_time->diffInWeeks($repeat_till);
                    $duration='addWeek';
                break;
                case 'monthly':
                    $no_of_slots=$start_time->diffInMonths($repeat_till);
                    $duration='addMonth';
                break;
                default:
                    $no_of_slots=0;
            }
            if ($no_of_slots) {
                for ($i = 0; $i < $no_of_slots; $i++) {
                    $start_time->{$duration}();
                    $end_time->{$duration}();
                    $slot->slots()->create([
                            'starts_at'    => $start_time,
                            'ends_at'      => $end_time,
                            'user_id'=>auth()->user()->id,
                            'recurrence'    => request('recurrence'),
                        ]);
                }
            }
        }
    }
}
