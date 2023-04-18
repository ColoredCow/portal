<?php

namespace Modules\operations\Entities;

use Illuminate\Database\Eloquent\Model;

class OfficeLocation extends Model
{
     protected $fillable = [
        'centre_name',
        'centre_head_id',
        'capacity',
        'current_people_count'
    ];
}
