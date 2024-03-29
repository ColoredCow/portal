<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HrFollowUpFactory;
use Modules\User\Entities\User;

class FollowUp extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'hr_follow_ups';

    public function conductedBy()
    {
        return $this->belongsTo(User::class, 'conducted_by');
    }
    public static function newFactory()
    {
        return new HrFollowUpFactory();
    }
}
