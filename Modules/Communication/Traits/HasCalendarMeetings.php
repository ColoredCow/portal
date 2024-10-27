<?php
namespace Modules\Communication\Traits;

use Modules\Communication\Entities\CalendarMeeting;

trait HasCalendarMeetings
{
    public function calendarMeeting()
    {
        return $this->belongsTo(CalendarMeeting::class);
    }

    public function getHangoutLinkAttribute()
    {
        return optional($this->calendarMeeting)->hangout_link;
    }
}
