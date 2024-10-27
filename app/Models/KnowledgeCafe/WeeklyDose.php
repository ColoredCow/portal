<?php

namespace App\Models\KnowledgeCafe;

use Illuminate\Database\Eloquent\Model;

class WeeklyDose extends Model
{
    protected $fillable = ['description', 'url', 'recommended_by'];
}
