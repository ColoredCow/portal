<?php

namespace Modules\CodeTrek\Http\Controllers;

use Aws\Api\Service;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\CodeTrek\Services\CodeTrekService;
use Modules\CodeTrek\Entities;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class CodeTrekController extends Controller
{
    protected $service;
    public function __construct(CodeTrekService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('codetrek::index', $this->service->getCodeTrekApplicants(request()->all()));
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
    public function store(Request $request, CodeTrekService $service)
    {
        $data = $request->all();
        $applicant = $service->store($data);

        return redirect()->route('codetrek.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CodeTrekService $service,$id)
    {
        $applicant = $this->service->edit($id);
        return view('codetrek::edit')->with('applicant', $applicant);
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     */
    public function update(Request $request,$id,CodeTrekService $service)
    {
        $data =$request->all();
        $applicant=$this->service->update($data,$id);

        return redirect()->route('codetrek.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
    }
}
