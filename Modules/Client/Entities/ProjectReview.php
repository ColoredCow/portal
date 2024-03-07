<?php

namespace Modules\Client\Entities;
use Modules\Client\Entities\Client;
use Modules\User\Entities\User;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class ProjectReview extends Model
{
    protected $fillable = [
        'client_id',
        'project_reviewer_id',
        'meeting_day',
        'meeting_time',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'project_reviewer_id', 'id')->withTrashed();
    }

    public function scopeTodayMeetings($query)
    {
        return $query->where('meeting_day', now()->dayOfWeek - 1)
            ->whereTime('meeting_time', '>', now()->format('H:i:s'));
    }

    public function getNextReviewDateAttribute()
    {
        $meetingDay = config('constants.working_week_days')[$this->meeting_day];
        $currentDay = now()->format('l');

        $meetingTime = optional($this)->meeting_time;


        // today
        if ($meetingDay == $currentDay && $meetingTime > now()->format('H:i:s')) {
            return now()->toDateString() . ' ' . $meetingTime;
        }

        return Carbon::parse('next ' . $meetingDay)->toDateString() . ' ' . $meetingTime;
    }
}
