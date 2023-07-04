<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;

class ClientOnboardingAnalyicsController extends Controller
{
    public function index()
    {
        $clients = Client::all();
    
        return view('clientanalytics::index', compact('clients'));
    }
}