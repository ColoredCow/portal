<?php

namespace App\Models\HR;

use App\Models\HR\ApplicantRound;
use Illuminate\Database\Eloquent\Model;

class ApplicantReview extends Model
{
    protected $fillable = ['hr_applicant_round_id', 'review_key', 'review_value'];

    protected $table = 'hr_applicant_reviews';

    public function applicantRound()
    {
    	return $this->belongsTo(ApplicantRound::class, 'hr_applicant_round_id');
    }
}
