<?php

namespace Modules\Project\Services;

use Modules\Client\Entities\Client;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectRepository;
use Modules\User\Entities\User;

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
            'effort_sheet_url' => $data['effort_sheet_url'] ?? null,
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

    public function getProjectRepositories(Project $project)
    {
        return $project->repositories;
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

            case 'project_repository':
                return $this->updateProjectRepositories($data, $project);
                break;
        }
    }

    private function updateProjectDetails($data, $project)
    {
        return $project->update([
            'name' => $data['name'],
            'client_id' => $data['client_id'],
            'status' => $data['status'],
            'project_type' => $data['project_type'],
            'total_estimated_hours' => $data['total_estimated_hours'] ?? null,
            'monthly_estimated_hours' => $data['monthly_estimated_hours'] ?? null,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'effort_sheet_url' => $data['effort_sheet_url'] ?? null,
        ]);
    }

    private function updateProjectResources($data, $project)
    {
        $projectResources = $data['projectResource'];
        $resources = [];

        foreach ($projectResources as $projectResource) {
            $resources[$projectResource['resource_id']] = ['designation' => $projectResource['designation']];
        }

        return $project->resources()->sync($resources);
    }

    private function updateProjectRepositories($data, $project)
    {
        if (! isset($data['url'])) {
            return;
        }

        $projectRepositoriesUrl = $data['url'];
        $urlIds = [];
        foreach ($projectRepositoriesUrl as $url) {
            $urlIds[] = $url;
            ProjectRepository::where('project_id', $project->id)->whereNotIn('url', $urlIds)->delete();
            ProjectRepository::updateOrCreate(
                [
                    'project_id' => $project->id,
                    'url' => $url,
                ],
            );
        }
    }

    private function getClientProjectID($clientID)
    {
        $client = Client::find($clientID);
        $clientProjectsCount = $client->projects->count() ?: 0;
        $clientProjectsCount = $clientProjectsCount + 1;

        return sprintf('%03s', $clientProjectsCount);
    }
}
