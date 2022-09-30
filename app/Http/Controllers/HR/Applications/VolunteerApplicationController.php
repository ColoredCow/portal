<?php

namespace App\Http\Controllers\HR\Applications;

use Modules\HR\Entities\Application;
use Modules\HR\Entities\Job;
use Illuminate\Support\Facades\Request;
use Modules\HR\Http\Controllers\Recruitment\ApplicationController;

class VolunteerApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'volunteer';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = [
            'status' => request()->get('status') ?: 'non-rejected',
            'job-type' => $this->getApplicationType(),
            'job' => request()->get('hr_job_id'),
            'name' => request()->get('search'),
        ];
        $applications = Application::with(['applicant', 'job'])
            ->applyFilter($filters)
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(Request::except('page'));

        $attr = [
            'applications' => $applications,
            'status' => request()->get('status'),
            'volunteer_on_hold_count' => $this->getCount(['on-hold']),
            'sent_for_approval_count' => $this->getCount(['sent-for-approval']),
            'no_show_count' => $this->getCount(['no-show-reminded']),
            'closed_count' => $this->getCount(['rejected']),
            'open_count' => $this->getCount(['new','in-progress']),
            'job-type' => $this->getApplicationType(),
            'jobs' => Job::where('type','volunteer')->get(),
        ];
        

        return view('hr.application.volunteer.index')->
            with($attr
            );
    }

    public function getCount($current_status){

        $jobs = Job::where('type','volunteer')->get('id');
        $data = [];
        foreach ($jobs as $job) {
            $data[] = $job->id;
        }
        $todayCount = Application::whereIn('hr_job_id', $data)
            ->whereIn('status',$current_status)
            ->count();
        return $todayCount;

    }
}
