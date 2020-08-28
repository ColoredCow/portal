<?php

namespace App\Models\HR;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slot extends Model
{
    use SoftDeletes;
    protected $table='hr_slots';
    protected $fillable=['starts_at','ends_at','user_id','recurrence'];
    
    protected $appends = ['start', 'end','color','url'];

    public function getStartAttribute()
    {
        return $this->starts_at;
    }
    
    public function getEndAttribute()
    {
        return $this->ends_at;
    }

    public function getColorAttribute()
    {
        return $this->is_booked?'green':'blue';
    }

    public function getUrlAttribute()
    {
        return route('hr.slots.edit', $this->id);
    }

    public function parent()
    {
        return $this->belongsTo(Slot::class, 'hr_parent_slot_id');
    }

    public function children()
    {
        return $this->hasMany(Slot::class, 'hr_parent_slot_id', 'id');
    }
}
