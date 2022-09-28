<?php

namespace Modules\HR\Http\Controllers\Recruitment;

use Modules\HR\Entities\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\HrJobDomain as EntitiesHrJobDomain;
use Modules\HR\Entities\Job;
use Carbon\Carbon;
use Modules\HR\Entities\Applicant;
use Modules\HR\Entities\Round;
use Modules\HR\Http\Requests\Recruitment\JobRequest;
use Modules\HR\Http\Requests\Recruitment\JobDomainRequest;
use Modules\User\Entities\User;
use Illuminate\Support\Str;
use Psy\Command\WhereamiCommand;
use Request;

class JobController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Job::class, null, [
            'except' => ['store', 'edit', 'update'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', Job::class);

        $jobs = Job::with([
            'applications' => function ($query) {
                $query->isOpen()->get();
            }
        ])
            ->latest()
            ->appends(Request::except('page'));

        request()->is('*recruitment/opportunities*') ? $jobs->typeRecruitment() : $jobs->typeVolunteer();
        $jobs->paginate(config('constants.pagination_size'));

        return view('hr.job.index')->with([
            'jobs' => $jobs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hr.job.create')->with([
            'rounds' => Round::all(),
            'interviewers' => User::interviewers()->get(),
            'domains' => EntitiesHrJobDomain::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  JobRequest  $request
     */
    public function store(JobRequest $request)
    {
        $validated = $request->validated();

        $opportunity = Job::create([
            'title' => $validated['title'],
            'domain' => $validated['domain'],
            'description' => $validated['description'] ?? null, // null needed for backward compatibility
            'type' => $validated['type'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'resources_required' => $validated['resources_required'],
        ]);
        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities.edit', $opportunity->id) : route('recruitment.opportunities.edit', $opportunity->id);

        return redirect($route)->with('status', "Successfully updated $opportunity->title!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Modules\HR\Entities\Job  $opportunity
     * @return \Illuminate\View\View
     */
    public function edit(Job $opportunity)
    {
        $opportunity->load('postedBy');

        return view('hr.job.edit')->with([
            'job' => $opportunity,
            'interviewers' => User::interviewers()->get(),
            'jobs' => EntitiesHrJobDomain::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  JobRequest  $request
     * @param  Job  $opportunity
     */
    public function update(JobRequest $request, Job $opportunity)
    {
        $validated = $request->validated();
        $opportunity->_update($validated);

        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities.edit', $opportunity->id) : route('recruitment.opportunities.edit', $opportunity->id);

        return redirect($route)->with('status', "Successfully updated $opportunity->title!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\HR\Entities\Job  $opportunity
     */
    public function destroy(Job $opportunity)
    {
        $route = $opportunity->type == 'volunteer' ? route('volunteer.opportunities') : route('recruitment.opportunities');
        $opportunity->delete();

        return redirect($route)->with('status', "Successfully deleted $opportunity->title!");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Modules\HR\Http\Requests\Recruitment\JobDomainRequest  $request
     */
    public function storeJobdomain(JobDomainRequest $request)
    {
        $hrJobDomains = new EntitiesHrJobDomain();
        $hrJobDomains->domain = $request['name'];
        $hrJobDomains->slug = Str::slug($request['name']);
        $hrJobDomains->save();

        return redirect()->back();
    }

    private function getVerifiedApplicationsCount()
    {
        $from = config('hr.verified_application_date.start_date');
        $currentDate = Carbon::today(config('constants.timezone.indian'));

        return Application::whereBetween('created_at', [$from, $currentDate])
            ->where('is_verified', 1)->count();
    }

    public function findApplicant()
    {
        $jobs = Job::where('type', 'volunteer')->get('id');
        //dd($jobs);

        $data = array();
        foreach ($jobs as $job) {
            $data[] = $job->id;
        }
        $todayCount = Application::whereDate('created_at', now())->whereIn('hr_job_id', $data)
            ->count();
        $record = Application::select(
            \DB::raw('COUNT(*) as count'),
            \DB::raw('MONTHNAME(created_at) as month_created_at'),
            \DB::raw('DATE(created_at) as date_created_at')
        )
            ->where('created_at', '>', Carbon::now()->subDays(23))
            ->whereIn('hr_job_id', $data)
            ->groupBy('date_created_at', 'month_created_at')
            ->orderBy('date_created_at', 'ASC')
            ->get();

        $data = [];
        $verifiedApplicationCount = $this->getVerifiedApplicationsCount();
        foreach ($record as $row) {
            $data['label'][] = (new Carbon($row->date_created_at))->format('M d');
            $data['data'][] = (int) $row->count;
            $verifiedApplications = Application::where('is_verified', 1)->whereDate('created_at', '=', date(new Carbon($row->date_created_at)))->count();
            $data['afterBody'][] = $verifiedApplications;
        }
        $data['chartData'] = json_encode($data);

        return view('hr.volunteers.reportresult')->with([
            'chartData' => $data['chartData'],
            'todayCount' => $todayCount,
            'verifiedApplicationsCount' => $verifiedApplicationCount
        ]);
    }
}
