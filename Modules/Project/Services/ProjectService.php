<?php

namespace Modules\Project\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Modules\User\Entities\User;
use Modules\Client\Entities\Client;
use Illuminate\Support\Facades\Auth;
use Modules\Project\Entities\Project;
use Illuminate\Support\Facades\Storage;
use Modules\Project\Entities\ProjectMeta;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Entities\ProjectRepository;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectBillingDetail;
use Modules\Project\Contracts\ProjectServiceContract;

class ProjectService implements ProjectServiceContract
{
    public function index(array $data = [])
    {
        $filters = [
            'status' => $data['status'] ?? 'active',
            'is_amc' => $data['is_amc'] ?? 0
        ];

        if ($nameFilter = $data['name'] ?? false) {
            $filters['name'] = $nameFilter;
        }

        $showAllProjects = Arr::get($data, 'projects', 'my-projects') != 'my-projects';

        $memberId = Auth::id();

        $projectClauseClosure = function ($query) use ($filters, $showAllProjects, $memberId) {
            $query->applyFilter($filters);
            $showAllProjects ? $query : $query->linkedToTeamMember($memberId);
        };

        $projectsData = Client::query()
        ->with('projects', $projectClauseClosure)
        ->whereHas('projects', $projectClauseClosure)
        ->orderBy('name')
        ->paginate(config('constants.pagination_size'));

        $tabCounts = $this->getListTabCounts($filters, $showAllProjects, $memberId);

        return array_merge(['clients' => $projectsData], $tabCounts);
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
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'effort_sheet_url' => $data['effort_sheet_url'] ?? null,
            'google_chat_webhook_url' => $data['google_chat_webhook_url'] ?? null,
            'type' => $data['project_type'],
            'total_estimated_hours' => $data['total_estimated_hours'] ?? null,
            'monthly_estimated_hours' => $data['monthly_estimated_hours'] ?? null,
            'is_amc' => array_key_exists('is_amc', $data) ? filter_var($data['is_amc'], FILTER_VALIDATE_BOOLEAN) : 0,
            'techstacks' => $data['project_name'],

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

    private function getListTabCounts($filters, $showAllProjects, $userId)
    {
        $counts = [
            'mainProjectsCount' => array_merge($filters, ['status' => 'active', 'is_amc' => false]),
            'AMCProjectCount' => array_merge($filters, ['status' => 'active', 'is_amc' => true]),
            'haltedProjectsCount' => array_merge($filters, ['status' => 'halted']),
            'inactiveProjectsCount' => array_merge($filters, ['status' => 'inactive'])
        ];

        foreach ($counts as $key => $tabFilters) {
            $query = Project::query()->applyFilter($tabFilters);
            $counts[$key] = $showAllProjects
                ? $query->count()
                : $query->linkedToTeamMember($userId)->count();
        }

        return $counts;
    }

    public function getClients()
    {
        return Client::where('status', 'active')->orderBy('name')->get();
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

            case 'project_financial_details':
                return $this->updateProjectFinancialDetails($data, $project);
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
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'effort_sheet_url' => $data['effort_sheet_url'] ?? null,
            'google_chat_webhook_url' => $data['google_chat_webhook_url'] ?? null,
            'is_amc' => array_key_exists('is_amc', $data) ? filter_var($data['is_amc'], FILTER_VALIDATE_BOOLEAN) : 0,
            'techstacks' => $data['project_stack'],
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

    private function updateProjectFinancialDetails($data, $project)
    {
        ProjectBillingDetail::updateOrCreate(
            ['project_id' => $project->id],
            $data
        );
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
                    'started_on' => $teamMemberData['started_on'] ?? now(),
                    'ended_on' => $teamMemberData['ended_on'],
                    'billing_engagement' => $teamMemberData['billing_engagement'],
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

    public function getWorkingDays($project)
    {
        $startDate = $project->client->month_start_date;
        $endDate = $project->client->month_end_date;
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

    public function getMailDetailsForKeyAccountManagers()
    {
        $zeroEffortProject = ProjectTeamMember::where('daily_expected_effort', 0)->get('project_id');
        $projects = Project::whereIn('id', $zeroEffortProject)->get();
        $keyAccountManagersDetails = [];
        foreach ($projects as $project) {
            $user = $project->client->keyAccountManager;
            if ($user) {
                $keyAccountManagersDetails[$user->id][] = [
                'project' =>$project,
                'email' =>$user->email,
                'name' =>$user->name,
            ];
            }
        }

        return $keyAccountManagersDetails;
    }

    public function getMailDetailsForProjectKeyAccountManagers()
    {
        $currenttime = Carbon::today(config('constants.timezone.indian'));
        $projects = Project::wheretype('fixed-budget')->wherestatus('active')->where('end_date', '<', $currenttime)->get();
        $projectsData = [];
        foreach ($projects as $project) {
            $user = $project->client->keyAccountManager;
            if ($user) {
                $projectsData[$user->id][] = [
                    'project' => $project,
                    'email' => $user->email,
                    'name' => $user->name,
                ];
            }
        }

        return $projectsData;
    }

    public function getMailDetailsForZeroExpectedHours()
    {
        $zeroEffortProjectsIds = ProjectTeamMember::where('daily_expected_effort', 0)->pluck('project_id');
        $projectsWithZeroEffort = Project::with(['teamMembers'])->whereIn('id', $zeroEffortProjectsIds)->get();
        $projectDetails = [];
        foreach ($projectsWithZeroEffort as $project) {
            foreach ($project->teamMembers as $teamMember) {
                if ($teamMember->getOriginal('pivot_daily_expected_effort') == 0) {
                    $projectDetails[] = [
                        'projects' => $project,
                        'name' => $teamMember->name,
                        'email' =>$teamMember->email,
                    ];
                }
            }
        }

        return $projectDetails;
    }
}
