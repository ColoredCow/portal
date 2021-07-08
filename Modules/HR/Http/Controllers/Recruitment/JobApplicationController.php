<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Modules\HR\Http\Controllers\Recruitment\ApplicationController;

class JobApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'job';
    }
}
