<?php

namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;

class ProspectStage extends Model
{
    protected $fillable = ['slug', 'name'];
}
