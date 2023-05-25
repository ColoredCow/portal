<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class ApplicantsComposer
{
    public function compose(View $view)
    {
        $applicants = CodeTrekApplicant::orderBy('first_name', 'asc')->get();

        $view->with('applicants', $applicants);
    }
}
