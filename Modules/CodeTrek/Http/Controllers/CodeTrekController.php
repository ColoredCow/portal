<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Modules\CodeTrek\Services\CodeTrekService;
use Modules\Operations\Entities\OfficeLocation;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Http\Requests\CodeTrekRequest;
use Modules\User\Entities\User;
use Carbon\Carbon;

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

        $centres = OfficeLocation::all();

        $mentors = User::all();
        $applicantData = $this->service->getCodeTrekApplicants($request->all());
        $applicants = $applicantData['applicants'];
        $statusCounts = $applicantData['statusCounts'];
        $start_date = Carbon::parse($request->application_start_date) ?? today()->subYear();
        $end_date = Carbon::parse($request->application_end_date) ?? today();
        $reportApplicationCounts = CodeTrekApplicant::select(\DB::Raw('DATE(start_date) as date, COUNT(*) as count'))
            ->whereDate('start_date', '>=', $start_date)
            ->whereDate('start_date', '<=', $end_date)
            ->count();

        return view('codetrek::index', [
            'applicants' => $applicants,
            'centres' => $centres,
            'mentors' => $mentors,
            'reportApplicationCounts' => $reportApplicationCounts,
            'statusCounts' => $statusCounts
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
    public function generatePDF(Request $request, CodeTrekApplicant $applicant)
    {
        $data = [
            'name' => $applicant['first_name'] . ' ' . $applicant['last_name'],
            'email' => $applicant->email,
            'start_date' => $applicant->start_date,
            'end_date' => date('Y-m-d'),
        ];

        $pdf = Pdf::loadView('codetrek::render.codetrek-certificate-template', $data);

        return $pdf->stream($data['name'] . ' codetrek certificate.pdf');
    }

    public function edit(CodeTrekApplicant $applicant)
    {
        // $this->authorize('update', $applicant);   There are some issues in the production, which is why these lines are commented out.

        $centres = OfficeLocation::all();

        $mentors = User::all();
        $this->service->edit($applicant);

        return view('codetrek::edit', ['applicant' => $applicant, 'centres' => $centres, 'mentors' => $mentors]);
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
        $candidateFeedbacks = $this->service->getCodeTrekApplicantFeedbacks($request['applicant']);
        $applicantDetails = CodeTrekApplicant::where('id', $request['applicant'])->first();

        return view('codetrek::feedback')->with([
        'candidateFeedbacks' => $candidateFeedbacks,
        'applicantDetails' =>  $applicantDetails
        ]);
    }
}
