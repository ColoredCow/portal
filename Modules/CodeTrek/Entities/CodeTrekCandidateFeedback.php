<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class CodeTrekCandidateFeedback extends Model
{
    protected $fillable = ['candidate_id', 'posted_by', 'category_id', 'latest_round_name', 'feedback', 'feedback_type', 'posted_on'];

    protected $table = 'code_trek_candidate_feedback';

    // public function candidate()
    // {
    //     return $this->belongsTo(CodeTrekApplicant::class, 'candidate_id');
    // }

    // public function category()
    // {
    //     return $this->belongsTo(CodeTrekFeedbackCategories::class, 'category_id');
    // }

    // public function users()
    // {
    //     return $this->belongsTo(User::class, 'posted_by');
    // }
}
