<?php

namespace Modules\Prospect\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    protected $fillable = ['created_by', 'status', 'assign_to', 'name', 'coming_from', 'coming_from_id', 'brief_info'];

    public function contactPersons()
    {
        return $this->hasMany(ProspectContactPerson::class);
    }

    public function assigneeTo()
    {
        return $this->belongsTo(User::class, 'assign_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
