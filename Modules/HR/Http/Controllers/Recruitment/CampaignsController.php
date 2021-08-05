<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Routing\Controller;

class CampaignsController extends Controller
{
    /**
     * Display the employee reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.recruitment.campaigns');
    }
}
