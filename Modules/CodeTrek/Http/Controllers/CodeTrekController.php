<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\CodeTrek\Http\Requests\CodeTrekRequest;
use Modules\CodeTrek\Services\CodeTrekService;

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
    public function edit(CodeTrekService $service, $id)
    {
        $applicant = $this->service->edit($id);

        return view('codetrek::edit')->with('applicant', $applicant);
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     */
    public function update(CodeTrekRequest $request, $id, CodeTrekService $service)
    {
        $this->service->update($request->all(), $id);

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