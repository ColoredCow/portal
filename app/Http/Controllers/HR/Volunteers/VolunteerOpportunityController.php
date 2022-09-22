<?php

namespace App\Http\Controllers\HR\Volunteers;

use Illuminate\Http\Request;
use Modules\HR\Entities\Job;
use Modules\HR\Http\Controllers\Recruitment\JobController;

class VolunteerOpportunityController extends JobController
{
    protected $service;
    public function getOpportunityType()
    {
        return 'volunteer';
    }

    public function AddUser()
    {
        return view('addUser');
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
            ->typeVolunteer()
            ->latest()
            ->paginate(config('constants.pagination_size'))
            ->appends(Request::except('page'));

        return view('hr.job.index')->with([
            'jobs' => $jobs,
            'type' => 'volunteer',
        ]);
    }
}
