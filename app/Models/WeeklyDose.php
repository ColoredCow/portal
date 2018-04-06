<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyDose extends Model
{
    protected $fillable = ['description', 'url', 'recommended_by'];
}
