<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class CodeTrekApplicantsComposer
{
    public function compose(View $view)
    {
        $codeTrekApplicants = CodeTrekApplicant::orderBy('first_name', 'asc')->get();

        $view->with('codeTrekApplicants', $codeTrekApplicants);
    }
}
