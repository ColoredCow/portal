<?php
namespace Modules\Communication\Http\Controllers;

use Illuminate\Routing\Controller;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('communication::index');
    }
}
