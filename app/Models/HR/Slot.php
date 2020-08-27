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
    
    public function parent()
    {
        return $this->belongsTo(Slot::class, 'hr_parent_slot_id');
    }

    public function children()
    {
        return $this->hasMany(Slot::class, 'hr_parent_slot_id', 'id');
    }
}
