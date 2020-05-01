<?php

namespace Modules\Prospect\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Prospect\Entities\Prospect;
use Modules\LegalDocument\Entities\LegalDocumentTemplate;

class ProspectAgreementController extends Controller
{
    protected $service;

    public function index(Prospect $prospect, $agreement)
    {
        return view('prospect::agreements')->with([
            'prospect' => $prospect,
            'agreement' => $agreement,
            'templates' => LegalDocumentTemplate::all()
        ]);
    }

    public function update(Request $request, Prospect $prospect, $agreement)
    {
        dd($request->all());
    }
}
