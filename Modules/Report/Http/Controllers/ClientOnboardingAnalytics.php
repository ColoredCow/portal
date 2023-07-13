<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;

class ClientOnboardingAnalytics extends Controller
{
    public function index()
    {
        $clients = Client::all();

        return view('report::ClientOnboarding.index', compact('clients'));
    }
}
