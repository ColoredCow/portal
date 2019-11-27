<?php

namespace App\Http\Controllers\Project;

use App\Models\Project;
use App\Http\Controllers\Controller;

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

    
}
