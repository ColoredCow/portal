<?php

namespace Modules\Project\Services;

use Modules\Client\Entities\Client;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectRepository;
use Modules\Project\Entities\ProjectHealth;
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
            'type' => $data['project_type'],
            'total_estimated_hours' => $data['total_estimated_hours'] ?? null,
            'monthly_estimated_hours' => $data['monthly_estimated_hours'] ?? null,
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

    public function getProjectHealth(Project $project)
    {
        return $project->projectHealthDetails;
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

            case 'project_team_members':
                return $this->updateProjectTeamMembers($data, $project);

            case 'project_repository':
                return $this->updateProjectRepositories($data, $project);

            case 'project_health':
                return $this->updateProjectHealthDetails($data, $project);
        }
    }

    private function updateProjectDetails($data, $project)
    {
        return $project->update([
            'name' => $data['name'],
            'client_id' => $data['client_id'],
            'status' => $data['status'],
            'type' => $data['project_type'],
            'total_estimated_hours' => $data['total_estimated_hours'] ?? null,
            'monthly_estimated_hours' => $data['monthly_estimated_hours'] ?? null,
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
            'effort_sheet_url' => $data['effort_sheet_url'] ?? null,
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

    private function updateProjectHealthDetails($data, $project)
    {
        ProjectHealth::updateOrCreate([
            'project_id' => $project->id,
            'staging_url' => $data['staging_url'],
            'onboarding_documents_url' => $data['onboarding_documents_url'],
            'has_issue_templates' => $data['has_issue_templates'],
            'has_unit_testing' => $data['has_unit_testing'],
            'has_ci_check' => $data['has_ci_check'],
            'has_site_monitoring' => $data['has_site_monitoring'],
            'has_error_logging' => $data['has_error_logging'],
            'has_error_reporting' => $data['has_error_reporting'],
        ]);
    }

    private function getClientProjectID($clientID)
    {
        $client = Client::find($clientID);
        $clientProjectsCount = $client->projects->count() ?: 0;
        $clientProjectsCount = $clientProjectsCount + 1;

        return sprintf('%03s', $clientProjectsCount);
    }
}
