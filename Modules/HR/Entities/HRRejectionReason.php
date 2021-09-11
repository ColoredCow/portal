<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class HRRejectionReason extends Model
{
    protected $table = 'hr_application_rejection_reasons';

    protected $fillable = ['hr_application_round_id', 'reason_title', 'reason_comment'];
}
