<?php

namespace App\Http\Controllers\HR\Applications;

use App\Http\Controllers\HR\Applications\ApplicationController;
use App\Models\HR\Application;
use Illuminate\Support\Facades\Input;

class VolunteerApplicationController extends ApplicationController
{
    public function getApplicationType()
    {
        return 'volunteer';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
            ->appends(Input::except('page'));

        $attr = [
            'applications' => $applications,
            'status' => request()->get('status'),
        ];

        return view('hr.application.volunteer.index')->with($attr);
    }
}
