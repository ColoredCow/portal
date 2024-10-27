<?php

namespace Modules\AppointmentSlots\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentSlot extends Model
{
    use SoftDeletes;
    protected $fillable = ['start_time', 'end_time', 'user_id', 'recurrence'];

    protected $dates = [
        'start_time',
        'end_time',
    ];

    public function scopeUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeFree($query)
    {
        return $query->where('status', 'free');
    }

    public function scopeFuture($query, $bufferInHours = 24)
    {
        $future = now()->startOfDay();
        if ($bufferInHours) {
            $future = $future->addHours($bufferInHours);
        }

        return $query->where('start_time', '>=', $future);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_appointment_slot_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_appointment_slot_id');
    }
}
