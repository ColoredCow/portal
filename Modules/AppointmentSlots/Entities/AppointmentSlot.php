<?php

namespace Modules\AppointmentSlots\Entities;

use Illuminate\Database\Eloquent\Model;

class AppointmentSlot extends Model
{
    protected $fillable = [];

    protected $dates = [
        'start_time',
        'end_time'
    ];

    public function scopeUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeFree($query)
    {
        return $query->where('status', 'free');
    }
}
