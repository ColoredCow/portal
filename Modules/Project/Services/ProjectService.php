<?php

namespace Modules\Project\Services;

use Modules\User\Entities\User;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Modules\Project\Contracts\ProjectServiceContract;

class ProjectService implements ProjectServiceContract
{
    public function index()
    {
        if (request()->get('projects') == 'all-projects') {
            return Project::where('status', request()->input('status', 'active'))
                ->get();
        } else {
            return auth()->user()->projects()->where('status', request()->input('status', 'active'))
            ->get();
        }
    }

    public function create()
    {
        return $this->getClients();
    }

    public function store($data)
    {
        return Project::create([
            'name' => $data['name'],
            'client_id' => $data['client_id'],
            'client_project_id' => $this->getClientProjectID($data['client_id']),
            'status' => 'active',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
        ]);
    }

    public function getClients()
    {
        return Client::where('status', 'active')->get();
    }

    public function getResources()
    {
        return User::all();
    }

    public function getResourcesDesignations()
    {
        return config('project.resource_designations');
    }

    public function getProjectResources(Project $project)
    {
        return $project->resources;
    }

    public function updateProjectData($data, $project)
    {
        $updateSection = $data['update_section'] ?? '';
        if (! $updateSection) {
            return false;
        }

        switch ($updateSection) {
            case 'project_details':
                return $this->updateProjectDetails($data, $project);
            break;

            case 'project_resources':
                return $this->updateProjectResources($data, $project);
            break;
        }
    }

    private function updateProjectDetails($data, $project)
    {
        return $project->update([
            'name' => $data['name'],
            'client_id' => $data['client_id'],
            'status' => $data['status'],
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
        ]);
    }

    private function updateProjectResources($data, $project)
    {
        $projectResources = $data['projectResource'];
        $resources = [];

        foreach ($projectResources as $projectResource) {
            //dd($projectResource);
            $resources[$projectResource['resource_id']] = ['designation' => $projectResource['designation']];
        }

        return $project->resources()->sync($resources);
    }

    private function getClientProjectID($clientID)
    {
        $client = Client::find($clientID);
        $clientProjectsCount = $client->projects->count() ?: 0;
        $clientProjectsCount = $clientProjectsCount + 1;

        return sprintf('%03s', $clientProjectsCount);
    }
}
