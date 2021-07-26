<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Illuminate\Support\Facades\Request;
use Modules\HR\Entities\Job;
use Modules\HR\Http\Controllers\Recruitment\JobController;
use Modules\HR\Http\Requests\Recruitment\JobRequest;
use Corcel\Model\Post as Corcel;

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

    public function store(JobRequest $request)
    {
        $validated = $request->validated();

        Corcel::updateOrCreate(
            ['post_type' => 'career', 'post_title' => $validated['title']],
            ['post_content' => $validated['description']]
        );

        $opportunity = Job::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'posted_by' => auth()->id(),
            'link' => $validated['link'] ?? null,
        ]);
        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities.edit', $opportunity->id) : route('recruitment.opportunities.edit', $opportunity->id);
        return redirect($route)->with('status', "Successfully updated $opportunity->title!");
    }

    public function destroy(Job $opportunity)
    {
        Corcel::where(['post_type' => 'career', 'post_title' => $opportunity['title']])->delete();
        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities') : route('recruitment.opportunities');
        $opportunity->delete();
        return redirect($route)->with('status', "Successfully deleted $opportunity->title!");
    }
}
