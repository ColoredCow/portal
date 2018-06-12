<?php

namespace App\Models\HR;

use App\Models\HR\Evaluation\Parameter as EvaluationParameter;
use App\Models\HR\Evaluation\Segment as EvaluationSegment;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = ['name', 'guidelines', 'confirmed_mail_template', 'rejected_mail_template'];

    protected $table = 'hr_rounds';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'confirmed_mail_template' => 'array',
        'rejected_mail_template' => 'array',
    ];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'hr_jobs_rounds', 'hr_round_id', 'hr_job_id')->withPivot('hr_job_id', 'hr_round_id', 'hr_round_interviewer');
    }

    public function evaluationParameters()
    {
        return $this->belongsToMany(EvaluationParameter::class, 'hr_round_evaluation', 'round_id', 'evaluation_id');
    }

    public function evaluationSegments()
    {
        return $this->belongsToMany(EvaluationSegment::class, 'hr_round_segment', 'round_id', 'segment_id');
    }
}
