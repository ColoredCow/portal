<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;

class CodeTrekCandidateFeedback extends Model
{
    protected $fillable = ['candidate_id', 'posted_by', 'category_id', 'latest_round_name', 'feedback', 'feedback_type', 'posted_on'];

    protected $table = 'code_trek_candidate_feedback';
}
