<?php

namespace Modules\CodeTrek\Entities;

use Illuminate\Database\Eloquent\Model;

class CodeTrekCandidateFeedback extends Model
{
    protected $guarded = [];

    protected $table = 'code_trek_candidate_feedback';

    public function getPostedByUserName($userId)
    {
        return User::select('name')->where('id', $userId)->first()->name;
    }

    public function getFeedbackCategoryName($categoryId)
    {
        return CodeTrekFeedbackCategories::select('category_name')->where('id', $categoryId)->first()->category_name;
    }
}
