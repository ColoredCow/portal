<?php

namespace App\Models\HR;

use App\Models\HR\ApplicationRound;
use App\Models\HR\EvaluationParameter;
use App\Models\HR\EvaluationParameterOption;
use Illuminate\Database\Eloquent\Model;

class ApplicationEvaluation extends Model
{
    protected $fillable = ['application_id', 'application_round_id', 'evaluation_id', 'option_id', 'comment'];

    protected $table = 'hr_application_evaluations';

    public function applicationRound()
    {
    	return $this->belongsTo(ApplicationRound::class, 'application_round_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
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
