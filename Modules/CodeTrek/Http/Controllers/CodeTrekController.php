<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Http\Requests\CodeTrekRequest;
use Modules\CodeTrek\Services\CodeTrekService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CodeTrekController extends Controller
{
    use AuthorizesRequests;
    protected $service;
    public function __construct(CodeTrekService $service)
    {
        $this->service = $service;
        $this->authorizeResource(CodeTrekApplicant::class, 'applicant');
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
    public function edit(CodeTrekApplicant $applicant)
    {
        $this->service->edit($applicant);

        return view('codetrek::edit')->with('applicant', $applicant);
    }

    /**
     * Update the specified resource in storage.
     * @param CodeTrekRequest $request
     */
    public function update(CodeTrekRequest $request, CodeTrekApplicant $applicant)
    {
        $this->service->update($request->all(), $applicant);

        return redirect()->route('codetrek.index');
    }
    public function delete(CodeTrekApplicant $applicant)
    {
        $this->authorize('codetrek_applicant.delete');

        $applicant->delete();

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
