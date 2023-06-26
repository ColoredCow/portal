<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Services\CodeTrekRoundDetailService;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;

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

    public function update(Request $request, CodeTrekApplicantRoundDetail $applicantDetail)
    {
        $this->service->update($request, $applicantDetail);

        return redirect()->back();
    }

    public function takeAction(Request $request, $id)
    {
        $this->service->takeAction($request, $id);

        return redirect()->back()->with('success', 'Round details updated successfully.');
    }

    public function updateStatus(Request $request, CodeTrekApplicant $applicant)
    {
        if ($request->input('action') === config('codetrek.status.inactive.slug')) {
            $applicant->status = config('codetrek.status.inactive.slug');
        } elseif ($request->input('action') === config('codetrek.status.active.slug')) {
            $applicant->status = config('codetrek.status.active.slug');
        } else {
            $applicant->status = config('codetrek.status.completed.slug');
        }

        $applicant->save();

        return redirect()->route('codetrek.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    }
}
