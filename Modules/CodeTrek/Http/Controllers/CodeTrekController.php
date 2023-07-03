<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Http\Requests\CodeTrekRequest;
use Modules\CodeTrek\Services\CodeTrekService;
use Modules\Operations\Entities\OfficeLocation;

class CodeTrekController extends Controller
{
    protected $service;

    public function __construct(CodeTrekService $service)
    {
        // $this->authorizeResource(CodeTrekApplicant::class);    There are some issues in the production, which is why these lines are commented out.
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $this->authorize('view', $applicant);     There are some issues in the production, which is why these lines are commented out.

        $centres = OfficeLocation::all();

        return view('codetrek::index', ['centres' => $centres], $this->service->getCodeTrekApplicants($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->authorize('create', $applicant);    There are some issues in the production, which is why these lines are commented out.

        $data = $request->all();
        $this->service->store($data);

        return redirect()->route('codetrek.index');
    }

    /**
     * Show the specified resource.
     */
    public function storeCodeTrekApplicantFeedback(Request $request)
    {
        $this->service->storeCodeTrekApplicantFeedback($request->all());

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CodeTrekApplicant $applicant)
    {
        // $this->authorize('update', $applicant);   There are some issues in the production, which is why these lines are commented out.

        $centres = OfficeLocation::all();
        $this->service->edit($applicant);

        return view('codetrek::edit', ['applicant' => $applicant, 'centres' => $centres]);
    }
    public function evaluate(CodeTrekApplicant $applicant)
    {
        // $this->authorize('update', $applicant);   There are some issues in the production, which is why these lines are commented out.

        $roundDetails = $this->service->evaluate($applicant);

        return view('codetrek::evaluate')->with(['applicant' => $applicant, 'roundDetails' => $roundDetails]);
    }
    /**
     * Update the specified resource in storage.
     * @param CodeTrekRequest $request
     */
    public function update(CodeTrekRequest $request, CodeTrekApplicant $applicant)
    {
        // $this->authorize('update', $applicant);   There are some issues in the production, which is why these lines are commented out.

        $this->service->update($request->all(), $applicant);

        return redirect()->route('codetrek.index');
    }
    public function delete(CodeTrekApplicant $applicant)
    {
        // $this->authorize('delete', $applicant);     There are some issues in the production, which is why these lines are commented out.

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

     public function getCodeTrekApplicantFeedback(Request $request)
     {
         $candidateFeedbacks = $this->service->getCandidateFeedbacks($request['applicantId']);
         $applicantDetails = CodeTrekApplicant::where('id', $request['applicantId'])->first();

         return view('codetrek::feedback')->with([
         'candidateFeedbacks' => $candidateFeedbacks,
         'applicantDetails' =>  $applicantDetails
         ]);
     }
}
