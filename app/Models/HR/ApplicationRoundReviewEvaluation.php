<?php

namespace App\Models\HR;

use App\Models\HR\EvaluationParameter;
use App\Models\HR\EvaluationParameterOption;
use Illuminate\Database\Eloquent\Model;

class ApplicationRoundReviewEvaluation extends Model
{
    protected $fillable = ['round_review_id', 'evaluation_id', 'option_id', 'comment'];

    protected $table = 'hr_application_round_review_evaluations';

    public function applicationRoundReview()
    {
    	return $this->belongsTo(ApplicationRoundReview::class, 'round_review_id');
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
