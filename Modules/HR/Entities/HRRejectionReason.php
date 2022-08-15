<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HRApplicationRejectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HRRejectionReason extends Model
{
    use HasFactory;
    protected $table = 'hr_application_rejection_reasons';

    protected $fillable = ['hr_application_round_id', 'reason_title', 'reason_comment'];
    public static function newFactory()
    {
        return new HRApplicationRejectionFactory();
    }
}
