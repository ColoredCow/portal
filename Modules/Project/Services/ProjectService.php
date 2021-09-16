<?php

namespace Modules\Project\Services;

use Modules\User\Entities\User;
use Modules\Client\Entities\Client;
use Modules\Project\Entities\Project;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Entities\ProjectRepository;

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
            'effort_sheet_url' => $data['effort_sheet_url'] ?? null
        ]);
    }

    public function getClients()
    {
        return Client::where('status', 'active')->get();
    }

    public function getTeamMembers()
    {
        return User::all();
    }

    public function getDesignations()
    {
        return config('project.designation');
    }

    public function getProjectTeamMembers(Project $project)
    {
        return $project->teamMembers;
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

            case 'project_team_members':
                return $this->updateProjectTeamMembers($data, $project);
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
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'effort_sheet_url' => $data['effort_sheet_url'] ?? null
        ]);
    }

    private function updateProjectTeamMembers($data, $project)
    {
        $projectTeamMembers = $data['project_team_member'] ?? [];
        $teamMembers = [];

        foreach ($projectTeamMembers as $projectTeamMember) {
            $teamMembers[$projectTeamMember['team_member_id']] = ['designation' => $projectTeamMember['designation']];
        }

        return $project->teamMembers()->sync($teamMembers);
    }

    private function updateProjectRepositories($data, $project)
    {
        if (! isset($data['url'])) {
            $project->repositories()->delete();

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
