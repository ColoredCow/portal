<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\CodeTrek\Services\CodeTrekRoundDetailService;

class CodeTrekApplicantRoundDetailController extends Controller
{
    protected $service;
    public function __construct(CodeTrekRoundDetailService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $this->service->update($request, $id);

        return redirect()->back();
    }

    public function takeAction(Request $request ,$id)
    {
        $this->service->takeAction($request,$id);

        return redirect()->back()->with('success', 'Round details updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    }
}
