<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekFeedbackCategories;

class CodeTrekApplicantsComposer
{
    public function compose(View $view)
    {
        $codeTrekApplicants = CodeTrekApplicant::where('status', 'active')
        ->orderBy('first_name', 'asc')
        ->get();

        $feedbackCategories = CodeTrekFeedbackCategories::all();
        $view->with(['codeTrekApplicants' => $codeTrekApplicants, 'feedbackCategories' => $feedbackCategories]);
    }
}
