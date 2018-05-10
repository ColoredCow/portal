<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Client;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view', new Project);

        return view('project.index')->with([
            'projects' => Project::getList(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        return view('project.create')->with([
            'clients' => Client::getActiveClients(),
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
        $this->authorize('create', Project::class);

        $validated = $request->validated();
        $project = Project::create([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
            'client_project_id' => $validated['client_project_id'],
            'status' => $validated['status'],
            'invoice_email' => $validated['invoice_email'],
        ]);
        return redirect("/projects/$project->id/edit")->with('status', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $project->load('stages', 'stages.billings', 'stages.billings.invoice');

        return view('project.edit')->with([
            'project' => $project,
            'clients' => Client::select('id', 'name')->get(),
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
        $this->authorize('update', $project);

        $validated = $request->validated();
        $updated = $project->update([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
            'client_project_id' => $validated['client_project_id'],
            'status' => $validated['status'],
            'invoice_email' => $validated['invoice_email'],
            'gst_applicable' => isset($validated['gst_applicable']) ? true : false,
        ]);
        return redirect("/projects/$project->id/edit")->with('status', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
    }
}
