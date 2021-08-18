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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('legaldocument::create');
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return view('legaldocument::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('legaldocument::edit');
    }
}
