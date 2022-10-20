<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Support\Facades\Request;
use Modules\HR\Entities\Job;

class RecruitmentOpportunityController extends JobController
{
    public function getOpportunityType()
    {
        return 'recruitment';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', Job::class);
        $search = request()->query('title') ?? '';
        if ($search != '') {
            $jobs = Job::where('title', 'LIKE', "%$search%")
                ->paginate(config('constants.pagination_size'));
        } else {
            $jobs = Job::with('applications', 'applications.applicant', 'jobRequisition')
                ->typeRecruitment()
                ->latest()
                ->paginate(config('constants.pagination_size'))
                ->appends(Request::except('page'));
        }
        return view('hr.job.index')->with([
            'jobs' => $jobs,
            'type' => 'recruitment',
        ]);
    }
}
