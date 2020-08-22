<?php

namespace App\Models\HR;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slots extends Model
{
    use SoftDeletes;
    protected $table='hr_slots';
    protected $fillable=['starts_at','ends_at','user_id','recurrence'];
    
    public function slot()
    {
        return $this->belongsTo(Slots::class, 'hr_slot_id');
    }

    public function slots()
    {
        return $this->hasMany(Slots::class, 'hr_slot_id', 'id');
    }
}
