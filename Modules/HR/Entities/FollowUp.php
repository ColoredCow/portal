<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class FollowUp extends Model
{
    protected $guarded = [];

    protected $table = 'hr_follow_ups';

    public function conductedBy()
    {
        return $this->belongsTo(User::class, 'conducted_by');
    }
}
