<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use IsMasterModel;
    protected $guarded = [];
}
