<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\HR\Applications\ApplicationController;

class JobApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'job';
    }
}
