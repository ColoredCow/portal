<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Prospect\Contracts\ProspectMeetingServiceContract;

class ProspectMeetingController extends Controller
{
    protected $service;

    public function __construct(ProspectMeetingServiceContract $service)
    {
        $this->service = $service;
    }

    public function store(Request $request, $prospect)
    {
        $this->service->schedule($request->all(), $prospect);

        return redirect()->back();
    }
}
