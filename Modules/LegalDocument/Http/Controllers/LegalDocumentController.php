<?php
namespace Modules\LegalDocument\Http\Controllers;

use Illuminate\Routing\Controller;

class LegalDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('legaldocument::index');
    }
}
