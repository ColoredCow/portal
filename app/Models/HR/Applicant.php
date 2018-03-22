<?php

namespace App\Models\HR;

use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = ['name', 'email', 'hr_job_id'];

    protected $table = 'hr_applicants';

    public function job()
    {
    	return $this->belongsTo(Job::class, 'hr_job_id');
    }

    public function applicantRounds()
    {
    	return $this->hasMany(ApplicantRound::class, 'hr_applicant_id');
    }
}
