<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class ApplicationRoundEvaluation extends Model
{
    protected $fillable = ['application_round_id', 'evaluation_id', 'option_id', 'comment'];

    protected $table = 'hr_application_round_evaluation';

    public function applicationRound()
    {
    	return $this->belongsTo(ApplicationRound::class, 'application_round_id');
    }

    public function evaluationParameter()
    {
        return $this->belongsTo(EvaluationParameter::class, 'evaluation_id');
    }

    public function evaluationOption()
    {
        return $this->belongsTo(EvaluationParameterOption::class, 'option_id');
    }
}
