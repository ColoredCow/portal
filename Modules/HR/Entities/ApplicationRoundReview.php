<?php

namespace Modules\HR\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\HR\Database\Factories\HRApplicationRoundReviewFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationRoundReview extends Model
{
    use HasFactory;
    protected $fillable = ['hr_application_round_id', 'review_key', 'review_value'];

    protected $table = 'hr_application_round_reviews';

    public function applicationRound()
    {
        return $this->belongsTo(ApplicationRound::class, 'hr_application_round_id');
    }
    public static function newFactory()
    {
        return new HrApplicationRoundReviewFactory();
    }
}
