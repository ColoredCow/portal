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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
    }
}
