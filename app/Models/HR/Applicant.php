<?php

namespace App\Models\HR;

use App\Events\HR\ApplicantCreated;
use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'resume', 'status', 'hr_job_id'];

    protected $table = 'hr_applicants';

    public static function _create($attr)
    {
        $applicant = self::create($attr);
        event(new ApplicantCreated($applicant));
        return $applicant;
    }

    public function _update($attr)
    {
        return $this->update($attr);
    }

    public function job()
    {
    	return $this->belongsTo(Job::class, 'hr_job_id');
    }

    public function applicantRounds()
    {
    	return $this->hasMany(ApplicantRound::class, 'hr_applicant_id');
    }
}
