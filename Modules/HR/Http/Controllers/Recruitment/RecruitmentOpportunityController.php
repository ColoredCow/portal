<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Support\Facades\Request;
use Modules\HR\Entities\Job;
use Modules\HR\Http\Requests\Recruitment\JobRequest;

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

        $jobs = Job::with('applications', 'applications.applicant')
            ->typeRecruitment()
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(Request::except('page'));

        return view('hr.job.index')->with([
            'jobs' => $jobs,
            'type' => 'recruitment',
        ]);
    }

    public function update(JobRequest $request, Job $opportunity)
    {
        $validated = $request->validated();
        $opportunity->update([
            'resources_required' => $request['resources_required'],
        ]);

        return redirect(route('recruitment.opportunities'))->with('status', 'Resources updated successfully!');
    }
}
