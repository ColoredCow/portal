<?php

namespace App\Models\HR;

use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = ['id'];

    protected $table = 'hr_applications';

    public function job()
    {
    	return $this->belongsTo(Job::class, 'hr_job_id');
    }
}
