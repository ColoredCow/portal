<?php

namespace App\Http\Controllers\HR\Applications;

class JobApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'job';
    }
}
