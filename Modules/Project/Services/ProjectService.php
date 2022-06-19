<?php

namespace Modules\Project\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Modules\Client\Entities\Client;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Entities\ProjectRepository;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Storage;
use Modules\Project\Entities\ProjectMeta;
use Modules\Project\Entities\ProjectTeamMember;
use Illuminate\Database\Eloquent\Collection;

class ProjectService implements ProjectServiceContract
{
    public function index(array $data = [])
    {
        $filters = [
            'status' => $data['status'] ?? 'active',
            'name' => $data['name'] ?? null,
        ];
        $data['projects'] = $data['projects'] ?? 'all-projects';

        $clients = null;
        $projectsCount = 0;

        if ($data['projects'] == 'all-projects') {
            $clients = Client::query()->with('projects', function ($query) use ($filters) {
                $query->applyFilter($filters)->orderBy('name', 'asc');
            })->whereHas('projects', function ($query) use ($filters) {
                $query->applyFilter($filters);
            })->orderBy('name')->get();

            $projectsCount = $clients->sum(function ($client) use ($filters) {
                return $client->projects()->applyFilter($filters)->count();
            });
        } else {
            $userId = auth()->user()->id;

            $clients = Client::query()->with('projects', function ($query) use ($userId, $filters) {
                $query->applyFilter($filters)->whereHas('getTeamMembers', function ($query) use ($userId) {
                    $query->where('team_member_id', $userId);
                });
            })->whereHas('projects', function ($query) use ($userId, $filters) {
                $query->applyFilter($filters)->whereHas('getTeamMembers', function ($query) use ($userId) {
                    $query->where('team_member_id', $userId);
                });
            })->get();

            $projectsCount = $clients->sum(function ($client) use ($filters, $userId) {
                return $client->projects()->applyFilter($filters)->whereHas('getTeamMembers', function ($query) use ($userId) {
                    $query->where('team_member_id', $userId);
                })->count();
            });
        }

        return [
            'clients' => $clients,
            'projectsCount' => $projectsCount,
        ];
    }

    public function create()
    {
        return $this->getClients();
    }

    public function store($data)
    {
        $project = Project::create([
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

        if ($data['billing_level'] ?? null) {
            ProjectMeta::updateOrCreate(
                [
                    'key' => config('project.meta_keys.billing_level.key'),
                    'project_id' => $project->id,
                ],
                [
                    'value' => $data['billing_level']
                ]
            );
        }

        $project->client->update(['status' => 'active']);
        $this->saveOrUpdateProjectContract($data, $project);
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

            case 'project_team_members':
                return $this->updateProjectTeamMembers($data, $project);

            case 'project_repository':
                return $this->updateProjectRepositories($data, $project);
        }
    }

    private function updateProjectDetails($data, $project)
    {
        $isProjectUpdated = $project->update([
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

        if ($data['billing_level'] ?? null) {
            ProjectMeta::updateOrCreate(
                [
                    'key' => config('project.meta_keys.billing_level.key'),
                    'project_id' => $project->id,
                ],
                [
                    'value' => $data['billing_level']
                ]
            );
        }

        $this->saveOrUpdateProjectContract($data, $project);
        if ($data['status'] == 'active') {
            $project->client->update(['status' => 'active']);
        } else {
            if (! $project->client->projects()->where('status', 'active')->exists()) {
                $project->client->update(['status' => 'inactive']);
            }
            $project->getTeamMembers()->update(['ended_on' => now()]);
        }

        return $isProjectUpdated;
    }

    private function updateProjectTeamMembers($data, $project)
    {
        $projectTeamMembers = $project->getTeamMembers;
        $teamMembersData = $data['project_team_member'] ?? [];
        foreach ($projectTeamMembers as $member) {
            $flag = false;
            foreach ($teamMembersData as $teamMemberData) {
                if ($member->id == $teamMemberData['project_team_member_id']) {
                    $flag = true;
                    $tempArray = $teamMemberData;
                    unset($tempArray['project_team_member_id']);
                    $member->update($tempArray);
                }
            }
            if (! $flag) {
                $member->update(['ended_on' => Carbon::now()]);
            }
        }

        foreach ($teamMembersData as $teamMemberData) {
            if ($teamMemberData['project_team_member_id'] == null) {
                ProjectTeamMember::create([
                    'project_id' => $project->id,
                    'team_member_id' => $teamMemberData['team_member_id'],
                    'designation' => $teamMemberData['designation'],
                    'daily_expected_effort' => $teamMemberData['daily_expected_effort'] ?? config('efforttracking.minimum_expected_hours'),
                ]);
            }
        }
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
    public function getWorkingDays()
    {
        $startDate = Carbon::now(config('constants.timezone.indian'))->startOfMonth();
        $endDate = Carbon::now(config('constants.timezone.indian'))->endOfMonth();
        $period = CarbonPeriod::create($startDate, $endDate);
        $numberOfWorkingDays = 0;
        $weekend = ['Saturday', 'Sunday'];
        foreach ($period as $date) {
            if (! in_array($date->format('l'), $weekend)) {
                $numberOfWorkingDays++;
            }
        }

        return $numberOfWorkingDays;
    }
    public function saveOrUpdateProjectContract($data, $project)
    {
        if ($data['contract_file'] ?? null) {
            $file = $data['contract_file'];
            $folder = '/contract/' . date('Y') . '/' . date('m');
            $fileName = $file->getClientOriginalName();
            $filePath = Storage::putFileAs($folder, $file, $fileName);
            ProjectContract::updateOrCreate(
                ['project_id' => $project->id],
                ['contract_file_path' => $filePath]
            );
        }
    }
    public function getTeamMembersWithZeroEffort($projectId, $teamMemberId){
        $teamMember = ProjectTeamMember::where('project_id', $projectId)->where('designation', '!=' ,'project_manager')->where('daily_expected_effort', '0')->get()->toArray();
        dd($teamMember);
    }
    public function getProjectManagerEmail($projectManagerId){
        $projectManagerEmail = User::where('id', $projectManagerId)->pluck('email')->toArray();
        return $projectManagerEmail;
    }
    public function getProjectManagerName($projectManagerId){
        $projectManagerEmail = User::where('id', $projectManagerId)->pluck('name')->toArray();
        return $projectManagerEmail;
    }
    // public function getZeroEffortTeamMemberInProject()
    // {
    //     $projects = Project::where('status', 'active')->get();
    //     $data = [];
    //     foreach ($projects as $project) {
    //         if(! is_null(self::getTeamMembersWithZeroEffort($project)) && ! is_null(self::getProjectManagerEmail($project))){
    //             $data[] = [
    //                 'project' => $project,
    //                 'teamMembers' => self::getTeamMembersWithZeroEffort($project),
    //                 'projectManagerName' => self::getProjectManagerEmail($project),
    //                 'projectManagerEmail' =>self::getProjectManagerEmail($project),
    //             ];
    //         }
    //         $projectDetails = Collection::make($data);
    //     }
    //     return $projectDetails;
    // }
    // public function getZeroEffortTeamMemberInProject()
    // {
    //     $projectManagers= ProjectTeamMember::where('designation', 'project_manager')->get();
    //     $projectManagers = $projectManagers->groupBy('team_member_id');
    //     foreach ($projectManagers as $key => $projectManager) {
    //         $projectManagerName = self::getProjectManagerName($key);
    //         $projectManagerEmail = self::getProjectManagerEmail($key);
    //         foreach ($projectManager as $key => $value){
    //             $projectTeamMembers = self::getTeamMembersWithZeroEffort($value->project_id);
    //             foreach ($projectTeamMembers as $key => $teamMember) {
    //                 if($teamMember->daily_expected_effort == 0){
    //                     $projects[] = Project::where('id', $value->project_id)->get();
    //                 }
    //             }
    //         }
    //         $data = [];
    //         if (! empty($projects) && ! empty($projectManagerName) && ! empty($projectManagerEmail)) {
    //             $data[] = [
    //                 'projects' => $projects,
    //                 'projectManagerName' => $projectManagerName,
    //                 'projectManagerEmail' =>$projectManagerEmail,
    //             ];
    //         }
    //     }
    //     $projectDetails = Collection::make($data);
    //     dd($projectDetails);
    //     return $projectDetails;
    // }

    public function getZeroEffortTeamMemberInProject()
    {
        $projectManagers= ProjectTeamMember::where('designation', 'project_manager')->get();
        $projectManagers = $projectManagers->groupBy('team_member_id');
        foreach ($projectManagers as $key => $projectManager) {
            foreach ($projectManager as $value){ 
                $projectTeamMembers[] = self::getTeamMembersWithZeroEffort($value->project_id, $value->team_member_id);
                dd($projectTeamMembers);
            }
            // dd($projects);
            $projectManagerName = self::getProjectManagerName($key);
            $projectManagerEmail = self::getProjectManagerEmail($key);
            $data[] = [
                // 'projects' => $projects,
                'projectManagerName' => $projectManagerName,
                'projectManagerEmail' =>$projectManagerEmail,
            ];
        }
        dd($data);
        return $projectDetails;
    }
}
