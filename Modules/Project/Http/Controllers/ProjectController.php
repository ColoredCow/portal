<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return Response
     */
    public function index()
    {
        $projects = $this->service->index();

        return view('project::index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $clients = $this->service->getClients();

        return view('project::create')->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
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
     * @return Response
     */
    public function show($id)
    {
        return view('project::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Project $project)
    {
        return view('project::edit', [
            'project' => $project,
            'clients' => $this->service->getClients(),
            'resources' => $this->service->getResources(),
            'projectResources' => $this->service->getProjectResources($project),
            'projectRepositories' => $this->service->getProjectRepositories($project),
            'resourcesDesignations' => $this->service->getResourcesDesignations(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Project $project)
    {
        return $this->service->updateProjectData($request->all(), $project);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
