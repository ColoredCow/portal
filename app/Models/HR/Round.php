<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = ['name'];

    protected $table = 'hr_rounds';

    public function jobs()
    {
    	return $this->belongsToMany(Job::class, 'hr_jobs_rounds', 'hr_round_id', 'hr_job_id')->withPivot('hr_job_id', 'hr_round_id', 'hr_round_interviewer');
    }
}
