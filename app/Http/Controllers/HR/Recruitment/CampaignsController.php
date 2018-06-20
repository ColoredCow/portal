<?php

namespace App\Http\Controllers\HR\Recruitment;

use App\Http\Controllers\Controller;

class CampaignsController extends Controller
{
    /**
     * Display the employee reports
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('hr.recruitment.campaigns');
    }
}
