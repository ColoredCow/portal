<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekFeedbackCategories;

class CodeTrekApplicantsComposer
{
    public function compose(View $view)
    {
        $codeTrekApplicants = CodeTrekApplicant::orderBy('first_name', 'asc')->get();

        $feedback_categories = CodeTrekFeedbackCategories::all();
        $view->with('codeTrekApplicants', $codeTrekApplicants)->with('feedback_categories', $feedback_categories);
    }
}
