<?php

namespace App\Models\HR;

use Illuminate\Database\Eloquent\Model;

class ApplicationRoundReview extends Model
{
    protected $fillable = ['hr_application_round_id', 'review_key', 'review_value'];

    protected $table = 'hr_application_round_reviews';

    public function applicationRound()
    {
    	return $this->belongsTo(ApplicationRound::class, 'hr_application_round_id');
    }
}
