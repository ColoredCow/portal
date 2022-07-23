<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class HrChannel extends Model
{
    public $timestamps = true;
    protected $table = 'hr_channels';
    protected $guarded = [];
}
