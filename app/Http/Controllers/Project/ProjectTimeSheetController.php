<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\TimesheetService;
use App\Http\Controllers\Controller;
use App\Models\Project\ProjectTimesheet;

class ProjectTimeSheetController extends Controller
{
    protected $service;

    public function __construct(TimesheetService $timesheetService)
    {
        $this->service = $timesheetService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Project $project)
    {
   
        return view('project.timesheet.index')->with([
            'project' => $project,
            'timesheets' => $project->timesheets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Project $project)
    {
        return view('project.timesheet.create')->with([
            'project' => $project,
        ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\View\View
    */
    public function store(Project $project, Request $request)
    {
        $project->timesheets()->create($request->all());
        return redirect()->route('project.timesheet', $project);
    }


    public function show(Project $project, ProjectTimesheet $timesheet)
    {
        return view('project.timesheet.show')->with([
            'project' => $project,
            'timesheet' => $timesheet,
            'monthDates' => $this->service->getMonthDates()
        ]);
    }

    public function newModule(ProjectTimesheet $timesheet) {
        $this->service->addNewModule($timesheet, request()->data());
        dd(request()->all());
    }
}
