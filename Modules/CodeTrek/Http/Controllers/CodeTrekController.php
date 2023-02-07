<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Illuminate\Http\Request;
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
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param int $id
     */
    public function update($id)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
    }
}
