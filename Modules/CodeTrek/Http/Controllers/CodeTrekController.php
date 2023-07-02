<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Http\Requests\CodeTrekRequest;
use Modules\CodeTrek\Services\CodeTrekService;
use Modules\Operations\Entities\OfficeLocation;
use Carbon\Carbon;

class CodeTrekController extends Controller
{
    use AuthorizesRequests;
    protected $service;

    public function __construct(CodeTrekService $service)
    {
        // $this->authorizeResource(CodeTrekApplicant::class);    There are some issues in the production, which is why these lines are commented out.
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CodeTrekApplicant $applicant)
    {
        // $this->authorize('view', $applicant);     There are some issues in the production, which is why these lines are commented out.

        $centres = OfficeLocation::all();
        $applicantData = $this->service->getCodeTrekApplicants($request->all());
        $applicants = $applicantData['applicants'];
        $applicantsData = json_encode($applicantData['applicantsData']);
        $statusCounts = $applicantData['statusCounts'];
        if($request->application_start_date && $request->application_end_date) {
            $applicantsGraph = $this->searchBydate($request);
        }
        else {
            $applicantChartData = CodeTrekApplicant::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
    
            $dates = $applicantChartData->pluck('date')->toArray();
            $counts = $applicantChartData->pluck('count')->toArray();
            $chartData = [
                'dates' => $dates,
                'counts' => $counts,
            ];
            $applicantsGraph = json_encode($chartData);
        }

        return view('codetrek::index', [
            'applicants' => $applicants,
            'centres' => $centres,
            'applicantsData' => $applicantsData,
            'statusCounts' => $statusCounts,
            'applicantsGraph' => $applicantsGraph
        ]);
    }

    public function searchBydate(Request $req)
    {
        $req->application_start_date = $req->application_start_date ?? carbon::now()->startOfMonth() == $req->application_end_date = $req->application_end_date ?? Carbon::today();

        // $todayCount = CodeTrekApplicant::whereDate('created_at', '=', Carbon::today())
        // ->count();
        
        $applicantsGraph = CodeTrekApplicant::select(
            \DB::raw('COUNT(*) as count'),
            \DB::raw('MONTHNAME(created_at) as month_created_at'),
            \DB::raw('DATE(created_at) as date_created_at'),
        )
            ->wheredate('created_at', '>=', $req->application_start_date)
            ->wheredate('created_at', '<=', $req->application_end_date)
            ->groupBy('date_created_at', 'month_created_at')
            ->orderBy('date_created_at', 'ASC')
            ->get();
        $data = [];
        $data['chartData'] = json_encode($data);

        return $applicantsGraph;
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
    public function store(Request $request, CodeTrekService $service, CodeTrekApplicant $applicant)
    {
        // $this->authorize('create', $applicant);    There are some issues in the production, which is why these lines are commented out.

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
}
