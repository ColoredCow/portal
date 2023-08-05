<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Prospect\Contracts\ProspectChecklistServiceContract;

class ProspectChecklistController extends Controller
{
    protected $service;

    public function __construct(ProspectChecklistServiceContract $service)
    {
        $this->service = $service;
    }

    public function show($prospect, $checklistID)
    {
        return view('prospect::checklist.prospect-nda.index', $this->service->show($prospect, $checklistID));
    }

    public function update(Request $request, $prospectID, $checklistID)
    {
        $data = $this->service->updateChecklist($request->all(), $prospectID, $checklistID);

        return redirect(route('prospect.show', $data['prospect']));
    }
}
