<?php

namespace Modules\Report\Entities;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['name', 'description', 'url', 'type'];
}
