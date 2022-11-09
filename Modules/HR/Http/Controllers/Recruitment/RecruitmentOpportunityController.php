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
        $jobs = Job::with('applications', 'applications.applicant', 'jobRequisition')
            ->typeRecruitment()
            ->latest();

        if ($search != '') {
            $jobs = $jobs->where('title', 'LIKE', "%$search%")->orwhere('type', 'LIKE', "%$search%");
        }
        $jobs = $jobs->paginate(config('constants.pagination_size'))
            ->appends(Request::except('page'));

        return view('hr.job.index')->with([
            'jobs' => $jobs,
            'type' => 'recruitment',
        ]);
    }
}
