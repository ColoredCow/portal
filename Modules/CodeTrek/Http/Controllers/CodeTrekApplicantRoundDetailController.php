<?php

namespace Modules\CodeTrek\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CodeTrek\Entities\CodeTrekApplicant;
use Modules\CodeTrek\Entities\CodeTrekApplicantRoundDetail;
use Modules\CodeTrek\Services\CodeTrekRoundDetailService;

class CodeTrekApplicantRoundDetailController extends Controller
{
    protected $service;
    public function __construct(CodeTrekRoundDetailService $service)
    {
        $this->service = $service;
    }

    public function update(Request $request, CodeTrekApplicantRoundDetail $applicantDetail)
    {
        $this->service->update($request, $applicantDetail);

        return redirect()->back()->with('success', 'Feedback updated successfully.');
    }

    public function takeAction(Request $request, $id)
    {
        $this->service->takeAction($request, $id);

        return redirect()->back()->with('success', 'Round details updated successfully.');
    }

    public function updateStatus(Request $request, CodeTrekApplicant $applicant)
    {
        $applicant->status = config('codetrek.status.completed.slug');

        if ($request->input('action') === config('codetrek.status.inactive.slug')) {
            $applicant->status = config('codetrek.status.inactive.slug');
        }

        if ($request->input('action') === config('codetrek.status.active.slug')) {
            $applicant->status = config('codetrek.status.active.slug');
        }

        $applicant->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
