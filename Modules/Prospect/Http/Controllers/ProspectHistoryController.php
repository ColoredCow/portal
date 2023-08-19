<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Prospect\Contracts\ProspectHistoryServiceContract;

class ProspectHistoryController extends Controller
{
    protected $service;

    public function __construct(ProspectHistoryServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request, $prospectId)
    {
        $this->service->store($request->all(), $prospectId);

        return redirect(route('prospect.show', $prospectId));
    }
}
