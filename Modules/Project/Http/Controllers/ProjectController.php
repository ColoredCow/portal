<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Project\Entities\Project;
use Modules\Project\Http\Requests\ProjectRequest;
use Modules\Project\Contracts\ProjectServiceContract;

class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = $this->service->index();

        return view('project::index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = $this->service->getClients();

        return view('project::create')->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     * @param ProjectRequest $request
     */
    public function store(ProjectRequest $request)
    {
        $validated = $request->validated();
        $this->service->store($validated);

        return redirect(route('project.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return view('project::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Project $project
     */
    public function edit(Project $project)
    {
        return view('project::edit', [
            'project' => $project,
            'clients' => $this->service->getClients(),
            'resources' => $this->service->getResources(),
            'projectResources' => $this->service->getProjectResources($project),
            'resourcesDesignations' => $this->service->getResourcesDesignations(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     */
    public function update(ProjectRequest $request, Project $project)
    {
        return $this->service->updateProjectData($request->all(), $project);
    }
}
