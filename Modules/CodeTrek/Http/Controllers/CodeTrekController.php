<?php

namespace Modules\CodeTrek\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Http\Requests\CodeTrekRequest;
use Modules\CodeTrek\Services\CodeTrekService;
use Modules\User\Entities\User;

class CodeTrekController extends Controller
{
    protected $service;
    protected $CodeTrekApplicant;

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

        $mentors = User::all();
        $applicantData = $this->service->getCodeTrekApplicants($request->all());
        $applicants = $applicantData['applicants'];
        $statusCounts = $applicantData['statusCounts'];
        $startDate = Carbon::parse($request->input('application_start_date', today()->subYear()));
        $endDate = Carbon::parse($request->input('application_end_date', today()));
        $reportApplicationCounts = CodeTrekApplicant::whereDate('start_date', '>=', $startDate)
            ->whereDate('start_date', '<=', $endDate)
            ->count();

        return view('codetrek::index', [
            'applicants' => $applicants,
            'mentors' => $mentors,
            'reportApplicationCounts' => $reportApplicationCounts,
            'statusCounts' => $statusCounts,
        ]);
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

        $mentors = User::all();
        $this->service->edit($applicant);

        return view('codetrek::edit', ['applicant' => $applicant,  'mentors' => $mentors]);
    }
    public function evaluate(CodeTrekApplicant $applicant)
    {
        // $this->authorize('update', $applicant);   There are some issues in the production, which is why these lines are commented out.

        $roundDetails = $this->service->evaluate($applicant);

        return view('codetrek::evaluate')->with(['applicant' => $applicant, 'roundDetails' => $roundDetails]);
    }
    /**
     * Update the specified resource in storage.
     *
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

    public function getCodeTrekApplicantFeedback(Request $request)
    {
        $candidateFeedbacks = $this->service->getCodeTrekApplicantFeedbacks($request['applicant']);
        $applicantDetails = CodeTrekApplicant::where('id', $request['applicant'])->first();

        return view('codetrek::feedback')->with([
        'candidateFeedbacks' => $candidateFeedbacks,
        'applicantDetails' =>  $applicantDetails,
        ]);
    }
}
