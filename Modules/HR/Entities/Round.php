<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Evaluation\Parameter as EvaluationParameter;
use Modules\HR\Entities\Evaluation\Segment as EvaluationSegment;

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

    public function isTrialRound()
    {
        return $this->name == 'Trial Program';
    }

    public function inPreparatoryRounds()
    {
        return self::whereIn('name', ['Preparatory-1', 'Preparatory-2', 'Preparatory-3', 'Preparatory-4', 'Warmup'])->where('id', $this->id)->exists();
    }

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
        return $this->hasMany(EvaluationSegment::class, 'round_id', 'id');
    }
}
