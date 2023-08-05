<?php

namespace Modules\ModuleChecklist\Http\Controllers;

use Illuminate\Routing\Controller;

class ModuleChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modulechecklist::index');
    }
}
