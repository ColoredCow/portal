<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    public $timestamps = true;
    protected $table = 'assessments';
    protected $guarded = [];
}
