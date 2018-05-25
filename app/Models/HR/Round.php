<?php

namespace App\Models\HR;

use App\Models\HR\EvaluationParameter;
use App\Models\HR\Job;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = ['name', 'guidelines'];

    protected $table = 'hr_rounds';

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'hr_jobs_rounds', 'hr_round_id', 'hr_job_id')->withPivot('hr_job_id', 'hr_round_id', 'hr_round_interviewer');
    }

    public function evaluationParameter()
    {
        return $this->belongsToMany(EvaluationParameter::class, 'hr_round_evaluation', 'round_id', 'evaluation_id');
    }
}
