<?php

namespace Modules\ModuleChecklist\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modulechecklist::create');
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return view('modulechecklist::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('modulechecklist::edit');
    }

}
