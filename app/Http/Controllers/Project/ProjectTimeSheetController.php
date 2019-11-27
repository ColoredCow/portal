<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project\ProjectTimesheet;

class ProjectTimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Project $project)
    {
        return view('project.timesheet.index')->with([
            'project' => $project,
            'timesheets' => $project->timesheets
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
}
