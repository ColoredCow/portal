<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\HR\Applications\ApplicationController;
use App\Models\HR\Application;
use App\Models\HR\Round;
use Illuminate\Http\Request;

class JobApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'job';
    }
}
