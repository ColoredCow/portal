<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use Modules\HR\Http\Controllers\Recruitment\ApplicationController;

class InternshipApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'internship';
    }
}
