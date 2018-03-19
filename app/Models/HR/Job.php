<?php

namespace App\Models\HR;

use App\Models\HR\Applicant;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title', 'posted_by', 'link'];

    protected $table = 'hr_jobs';

    public function applicants()
    {
    	return $this->hasMany(Applicant::class, 'hr_job_id');
    }

    public function getApplicantsByStatus($status = '')
    {
    	return $this->applicants->where('status', $status);
    }
}
