<?php

namespace Modules\Communication\Entities;

use Illuminate\Database\Eloquent\Model;

class CalendarMeeting extends Model
{
    protected $fillable = ['created_by', 'organizer_id', 'attendees', 'event_title', 'start_at', 'ends_at', 'calendar_event', 'hangout_link'];

    protected $casts = [
        'attendees' => 'array',
        'start_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}
