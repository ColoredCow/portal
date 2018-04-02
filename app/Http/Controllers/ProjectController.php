<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Client;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('project.index')->with([
            'projects' => Project::with('client')->orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('project.create')->with([
            'clients' => Client::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectRequest $request)
    {
        $validated = $request->validated();
        $invoice = Project::create([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
            'client_project_id' => $validated['client_project_id'],
            'status' => $validated['status'],
            'started_on' => $validated['started_on'] ? Carbon::parse(str_replace('/', '-', $validated['started_on']))->format(config('constants.date_format')) : null,
            'invoice_email' => $validated['invoice_email'],
        ]);

        return redirect('/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        return view('project.edit')->with([
            'project' => $project,
            'clients' => Client::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        $updated = $project->update([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
            'client_project_id' => $validated['client_project_id'],
            'status' => $validated['status'],
            'started_on' => $validated['started_on'] ? Carbon::parse(str_replace('/', '-', $validated['started_on']))->format(config('constants.date_format')) : null,
            'invoice_email' => $validated['invoice_email'],
        ]);
        return redirect('/projects/' . $project->id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function destroy(Project $project)
    {
        //
    }
}
