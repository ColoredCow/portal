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
