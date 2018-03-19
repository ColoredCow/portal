<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'posted_by', 'link'];

    protected $table = 'hr_jobs';
}
