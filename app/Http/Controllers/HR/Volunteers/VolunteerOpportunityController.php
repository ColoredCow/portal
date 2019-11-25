<?php

namespace App\Http\Controllers\HR\Volunteers;

use App\Models\HR\Job;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HR\JobController;

class VolunteerOpportunityController extends JobController
{
    public function getOpportunityType()
    {
        return 'volunteer';
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
            }])
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
