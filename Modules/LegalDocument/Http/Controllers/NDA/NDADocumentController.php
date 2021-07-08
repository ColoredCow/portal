<?php

namespace Modules\LegalDocument\Http\Controllers\NDA;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class NDADocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('legaldocument::nda.index');
    }
}
