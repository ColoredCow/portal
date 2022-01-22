<?php

namespace Modules\Project\Services;

use Modules\Client\Entities\Client;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectRepository;
use Modules\User\Entities\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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

    public function getUsers()
    {
        return User::all();
    }

    public function show($project)
    {
        $teamMembers = $project->getTeamMembers()->get();
        $totalEffort = 0;
        $workingDays = $this->getWorkingDays(now()->startOfMonth(), now());
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        $totalWorkingDays = count($this->getWorkingDays($startDate, $endDate));
        $teamMembersDetails = $this->getTeamMembersDetails($teamMembers);
        $expectedHours = $this->getExpectedHours(count($workingDays));

        return [
            'users' => json_encode($teamMembersDetails['users']),
        ];
    }

    /**
     * Calculate FTE.
     * @param  int $currentHours  Current Hours.
     * @param  int $expectedHours Expected Hours.
     * @return float              FTE
     */
    public function getFTE($currentHours, $expectedHours)
    {
        return round($currentHours / $expectedHours, 2);
    }

    /**
     * Get expected hours.
     * @param  int $numberOfDays Number of days.
     * @return int|float         Expected hours.
     */
    public function getExpectedHours($numberOfDays)
    {
        return config('efforttracking.minimum_expected_hours') * $numberOfDays;
    }

    /**
     * Get working days.
     * @param  object $startDate Start Date.
     * @param  object $endDate   End Date.
     * @return array             Working Days dates.
     */
    public function getWorkingDays($startDate, $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = [];
        $weekend = ['Saturday', 'Sunday'];
        foreach ($period as $date) {
            if (! in_array($date->format('l'), $weekend)) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        return $dates;
    }

    /**
     * Get Team members details.
     * @param  array $teamMembers Team Members.
     * @return array
     */
    public function getTeamMembersDetails($teamMembers)
    {
        $teamMembersEffort = [];
        $users = [];
        $startDate = now()->startOfMonth()->toDateString();
        $endDate = now()->endOfMonth()->toDateString();
        foreach ($teamMembers as $teamMember) {
            $userDetails = $teamMember->getUserDetails;
            $efforts = $teamMember->projectTeamMemberEffort()->get();
            if ($efforts->isNotEmpty()) {
                foreach ($efforts as $effort) {
                    $effortAddedOn = new Carbon($effort->added_on);
                    $teamMembersEffort[$userDetails->id][$effort->id]['name'] = $userDetails->name;
                    if ($startDate <= $effortAddedOn && $effortAddedOn <= $endDate) {
                        $teamMembersEffort[$userDetails->id][$effort->id]['actual_effort'] = $effort->actual_effort;
                        $teamMembersEffort[$userDetails->id][$effort->id]['total_effort_in_effortsheet'] = $effort->total_effort_in_effortsheet;
                        $teamMembersEffort[$userDetails->id][$effort->id]['added_on'] = $effortAddedOn->format('Y-m-d');
                    }
                }
            }
            $total_effort_in_effortsheet = $efforts->isNotEmpty() ? end($teamMembersEffort[$userDetails->id])['total_effort_in_effortsheet'] : 0;
            $users[] = [
                    'FTE' => $this->getFTE($total_effort_in_effortsheet, $this->getExpectedHours(count($this->getWorkingDays(now()->startOfMonth(), now())))),
            ];
        }

        return [
            'users' => $users,
        ];
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

    private function getClientProjectID($clientID)
    {
        $client = Client::find($clientID);
        $clientProjectsCount = $client->projects->count() ?: 0;
        $clientProjectsCount = $clientProjectsCount + 1;

        return sprintf('%03s', $clientProjectsCount);
    }
}
