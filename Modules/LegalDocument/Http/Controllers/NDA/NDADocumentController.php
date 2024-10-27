<?php
namespace Modules\LegalDocument\Http\Controllers\NDA;

use Illuminate\Routing\Controller;

class NDADocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('legaldocument::nda.index');
    }
}
