<?php

namespace App\Models\HR;

use App\Models\HR\ApplicationRound;
use App\Models\HR\EvaluationParameter;
use Illuminate\Database\Eloquent\Model;

class ApplicationRoundReviewEvaluation extends Model
{
    protected $fillable = ['round_review_id', 'evaluation_id', 'score', 'comment'];

    protected $table = 'hr_application_round_review_evaluations';

    public function applicationRoundReview()
    {
    	return $this->belongsTo(ApplicationRoundReview::class, 'round_review_id');
    }

    public function evaluation()
    {
        return $this->belongsTo(EvaluationParameter::class, 'evaluation_id');
    }
}
