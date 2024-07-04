<?php

namespace Modules\Project\Services;

use App\Models\Comment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Client\Entities\Client;
use Modules\HR\Entities\Employee;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectBillingDetail;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Entities\ProjectInvoiceTerm;
use Modules\Project\Entities\ProjectMeta;
use Modules\Project\Entities\ProjectRepository;
use Modules\Project\Entities\ProjectResourceRequirement;
use Modules\Project\Entities\ProjectStages;
use Modules\Project\Entities\ProjectStagesListing;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\ProjectTeamMembersEffort;
use Modules\Project\Exports\ProjectFTEExport;
use Modules\User\Entities\User;

class ProjectService implements ProjectServiceContract
{
    public function index(array $data = [])
    {
        $filters = [
            'status' => $data['status'] ?? 'active',
            'is_amc' => $data['is_amc'] ?? 0,
        ];

        $nameFilter = $data['name'] ?? false;

        if ($nameFilter) {
            $filters['name'] = $nameFilter;
        }
        $hasAnyRole = false;
        foreach (auth()->user()->roles as $role) {
            if ($role['name'] == 'admin' || $role['name'] == 'super-admin') {
                $hasAnyRole = true;
                break;
            }
        }
        if ($hasAnyRole) {
            $showAllProjects = Arr::get($data, 'projects', 'all-projects') == 'all-projects';
        } else {
            $showAllProjects = Arr::get($data, 'projects', 'my-projects') != 'my-projects';
        }
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
            'status' => $data['status'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'effort_sheet_url' => $data['effort_sheet_url'] ?? null,
            'google_chat_webhook_url' => $data['google_chat_webhook_url'] ?? null,
            'type' => $data['project_type'],
            'total_estimated_hours' => $data['total_estimated_hours'] ?? null,
            'monthly_estimated_hours' => $data['monthly_estimated_hours'] ?? null,
            'is_amc' => array_key_exists('is_amc', $data) ? filter_var($data['is_amc'], FILTER_VALIDATE_BOOLEAN) : 0,
        ]);

        if ($data['billing_level'] ?? null) {
            ProjectMeta::updateOrCreate(
                [
                    'key' => config('project.meta_keys.billing_level.key'),
                    'project_id' => $project->id,
                ],
                [
                    'value' => $data['billing_level'],
                ]
            );
        }

        $project->client->update(['status' => 'active']);
        $this->saveOrUpdateProjectContract($data, $project);
    }

    public function getClients($status = 'active')
    {
        if ($status == 'all') {
            $client = Client::orderBy('name')->get();
        } else {
            $client = Client::where('status', $status)->orderBy('name')->get();
        }

        return $client;
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

            case 'project_techstack':
                return $this->updateProjectTechstack($data, $project);

            case 'project_resource_requirement':
                return $this->updateProjectRequirement($data, $project);
        }
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
        $zeroEffortProject = ProjectTeamMember::where('daily_expected_effort', 0)->whereNull('ended_on')->get('project_id');
        $projects = Project::whereIn('id', $zeroEffortProject)->where('status', 'active')->get();
        $keyAccountManagersDetails = [];
        foreach ($projects as $project) {
            $user = $project->client->keyAccountManager;
            if ($user) {
                $keyAccountManagersDetails[$user->id][] = [
                    'project' => $project,
                    'email' => $user->email,
                    'name' => $user->name,
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
        $projectsWithZeroEffort = Project::with(['teamMembers'])->whereIn('id', $zeroEffortProjectsIds)->where('status', 'active')->get();
        $projectDetails = [];
        foreach ($projectsWithZeroEffort as $project) {
            foreach ($project->teamMembers as $teamMember) {
                if ($teamMember->getOriginal('pivot_daily_expected_effort') == 0) {
                    $projectDetails[] = [
                        'projects' => $project,
                        'name' => $teamMember->name,
                        'email' => $teamMember->email,
                    ];
                }
            }
        }

        return $projectDetails;
    }

    public function projectFTEExport($filters)
    {
        $year = (int) $filters['year'];
        $month = (int) $filters['month'];
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = date('Y-m-d');

        if ($startDate < date('Y-m-01')) {
            $endDate = (clone $startDate)->endOfMonth()->toDateString();
        }

        $startDate = $startDate->toDateString();

        $employees = Employee::applyFilters($filters)
            ->get();

        $employees = $this->formatProjectFTEFOrExportAll($employees, $startDate, $endDate);
        $filename = 'FTE_Report-' . $endDate . '.xlsx';

        return Excel::download(new ProjectFTEExport($employees), $filename);
    }

    public function getProjectsWithTeamMemberRequirementData($request)
    {
        $projectsWithTeamMemberRequirement = Project::query()
        ->with('client')
        ->status('active')
        ->withCount('getTeamMembers as team_member_count')
        ->withSum('resourceRequirement as team_member_needed', 'total_requirement')
        ->havingRaw('team_member_needed - team_member_count')
        ->when($request, function ($query, $request) {
            return $query->where('name', 'like', '%' . $request['name'] . '%');
        })
        ->get();

        $totalAdditionalResourceRequired = [];
        $data = [];
        $totalAdditionalResourceRequired = 0;
        foreach ($projectsWithTeamMemberRequirement as $project) {
            $count = $project->team_member_needed - $project->team_member_count;
            $totalAdditionalResourceRequired += $count;
            $projectData = [
                'totalResourceRequirement' => $project->team_member_needed,
                'totalResourceDeployed' => $project->team_member_count,
                'additionalResourceRequired' => $project->team_member_needed - $project->team_member_count,
                'teamMemberNeededByDesignation' => [],
                'currentTeamMemberCountByDesignation' => [],
                'object' => $project,
            ];

            $designations = $this->getDesignations();
            $designationKeys = array_keys($designations);

            foreach ($designationKeys as $designationName) {
                $totalResourceRequirementCount = $project->getResourceRequirementByDesignation($designationName)->total_requirement;
                if ($totalResourceRequirementCount > 0) {
                    $projectData['teamMemberNeededByDesignation'][$designations[$designationName]] = $totalResourceRequirementCount;
                }
                $totalResourceDeployedCount = $project->getDeployedCountForDesignation($designationName);
                if ($totalResourceDeployedCount > 0) {
                    $projectData['currentTeamMemberCountByDesignation'][$designations[$designationName]] = $totalResourceDeployedCount;
                }
                $count = $totalResourceRequirementCount - $totalResourceDeployedCount;
                $projectData['countByDesignation'][$designations[$designationName]] = $count;
            }
            $data[$project->client->name][$project->name] = $projectData;
        }

        return [
            'totalCount' => $totalAdditionalResourceRequired,
            'data' => $data,
        ];
    }

    public function getProjectWorkingDays($startDate, $endDate)
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

    public function getProjectApprovedPipelineHour($project)
    {
        $totalDailyExpectedEffort = ProjectTeamMember::where('project_id', $project->id)
        ->whereNull('ended_on')
        ->get()
        ->sum('daily_expected_effort');
        $workingDaysInMonth = $this->getWorkingDays($project);
        $totalExpectedHourInMonth = $totalDailyExpectedEffort * $workingDaysInMonth;
        $monthlyApprovedHour = $project->monthly_approved_pipeline;
        $totalWeeklyExpectedEffort = $totalDailyExpectedEffort * 5;
        $remainingApprovedPipeline = 0;
        if (is_int($monthlyApprovedHour) || is_float($monthlyApprovedHour)) {
            $remainingApprovedPipeline = $monthlyApprovedHour - $totalWeeklyExpectedEffort;
        }
        $currentActualEffort = ProjectTeamMembersEffort::whereIn('project_team_member_id', function ($query) use ($project) {
            $query->select('id')
                ->from('project_team_members')
                ->where('project_id', $project->id)
                ->whereNull('ended_on');
        })
        ->whereDate('created_at', now()->toDateString())
        ->sum('total_effort_in_effortsheet');
        $remainingExpectedEffort = $totalExpectedHourInMonth - $currentActualEffort;
        $currentDate = now(config('constants.timezone.indian'));
        $daysTillToday = count($this->getProjectWorkingDays($project->client->month_start_date, $currentDate));
        $remainingDays = $workingDaysInMonth - $daysTillToday;
        $daysInAWeek = 5;
        $weeklyHoursToCover = 0;
        if ($remainingDays !== 0) {
            $weeklyHoursToCover = $remainingExpectedEffort / $remainingDays * $daysInAWeek;
        }

        return [
            'monthlyApprovedHour' => $monthlyApprovedHour,
            'totalExpectedHourInMonth' => $totalExpectedHourInMonth,
            'totalWeeklyEffort' => $totalWeeklyExpectedEffort,
            'remainingApprovedPipeline' => $remainingApprovedPipeline,
            'remainingExpectedEffort' => $remainingExpectedEffort,
            'weeklyHoursToCover' => $weeklyHoursToCover,
        ];
    }

    public function getInvoiceTerms($project)
    {
        $invoiceTerms = ProjectInvoiceTerm::where('project_id', $project->id)->with('comments')->get();

        return $invoiceTerms;
    }

    public function saveOrUpdateDeliveryReport($data, $project, $index)
    {
        if ($data['delivery_report'] ?? null) {
            $file = $data['delivery_report'];
            $folder = '/delivery_report/' . date('Y') . '/' . date('m');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = $project->name . '_' . $index + 1 . '.' . $extension;

            return Storage::putFileAs($folder, $file, $fileName);
        }
    }

    public function showDeliveryReport($invoiceId)
    {
        $invoiceTerm = ProjectInvoiceTerm::where('id', $invoiceId)->first();
        $filePath = storage_path('app/' . $invoiceTerm->delivery_report);
        $content = file_get_contents($filePath);
        $deliveryReport = pathinfo($invoiceTerm->delivery_report)['filename'];

        return response($content)->withHeaders([
            'content-type' => mime_content_type($filePath),
            'deliveryReport' => $deliveryReport,
        ]);
    }

    public function getPendingDeliveryReportInvoices()
    {
        $currentDate = Carbon::now();
        $futureDate = $currentDate->copy()->addDays(config('constants.finance.scheduled-invoice.delivery-report-reminder-days'));

        $groupedInvoices = ProjectInvoiceTerm::where('invoice_date', '<=', $futureDate)
            ->where('report_required', true)
            ->where('delivery_report', null)
            ->whereNotIn('status', ['sent', 'paid'])
            ->whereMonth('invoice_date', strval($currentDate->month))
            ->with('project')
            ->get()
            ->groupBy('project_id');

        $keyAccountManagersDetails = [];

        $groupedInvoices->each(function ($invoiceTerms, $projectId) use (&$keyAccountManagersDetails) {
            $project = $invoiceTerms->first()->project;
            $user = $project->client->keyAccountManager;

            if ($user) {
                $userId = $user->id;

                if (! isset($keyAccountManagersDetails[$userId])) {
                    $keyAccountManagersDetails[$userId] = (object) [
                        'invoiceTerms' => collect(),
                        'email' => $user->email,
                        'name' => $user->name,
                    ];
                }

                $keyAccountManagersDetails[$userId]->invoiceTerms = $keyAccountManagersDetails[$userId]->invoiceTerms->merge($invoiceTerms);
            }
        });

        return $keyAccountManagersDetails;

    public function getProjectStages(Project $project)
    {
        $project_id = $project->id;
        $stages = ProjectStages::where('project_id', $project_id)->orderBy('id')->get();

        return $stages;
    }

    public function storeStage(array $newStages, int $projectId)
    {
        foreach ($newStages as $stage) {
            $stageData = $this->prepareStageData($stage);

            ProjectStages::create(array_merge($stageData, [
                'project_id' => $projectId,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function updateStage(array $updatedStages)
    {
        foreach ($updatedStages as $stage) {
            $stageData = $this->prepareStageData($stage);

            $existingStage = ProjectStages::find($stage['id']);
            if ($existingStage) {
                $existingStage->update(array_merge($stageData, [
                    'updated_at' => now(),
                ]));
            }
        }
    }

    public function removeStage(array $idArr)
    {
        ProjectStages::whereIn('id', $idArr)->delete();
    }

    public function createProjectStageList(string $stageName)
    {
        $formattedStageName = strtolower($stageName);
        ProjectStagesListing::firstOrCreate(
            ['name' => $formattedStageName]
        );
    }

    private function prepareStageData(array $stage): array
    {
        $startDate = null;
        $endDate = null;
        $duration = null;

        if ($stage['start_date']) {
            $formattedStartDate = Carbon::parse($stage['start_date']);
            $startDate = $formattedStartDate->setTimezone(config('app.timezone'))->format(config('constants.datetime_format'));
        }

        if ($stage['end_date']) {
            $formattedEndDate = Carbon::parse($stage['end_date']);
            $endDate = $formattedEndDate->setTimezone(config('app.timezone'))->format(config('constants.datetime_format'));
            $duration = Carbon::parse($stage['start_date'])->diffInSeconds($formattedEndDate);
        }

        $this->createProjectStageList($stage['stage_name']);

        return [
            'stage_name' => $stage['stage_name'],
            'comments' => $stage['comments'] ?? null,
            'status' => $stage['status'] ?? 'pending',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'expected_end_date' => $stage['expected_end_date'],
            'duration' => $duration,
        ];
    }

    private function getListTabCounts($filters, $showAllProjects, $userId)
    {
        $counts = [
            'mainProjectsCount' => array_merge($filters, ['status' => 'active', 'is_amc' => false]),
            'AMCProjectCount' => array_merge($filters, ['status' => 'active', 'is_amc' => true]),
            'haltedProjectsCount' => array_merge($filters, ['status' => 'halted', 'is_amc' => false]),
            'inactiveProjectsCount' => array_merge($filters, ['status' => 'inactive', 'is_amc' => false]),
        ];

        foreach ($counts as $key => $tabFilters) {
            $query = Project::query()->applyFilter($tabFilters);
            $counts[$key] = $showAllProjects
                ? $query->count()
                : $query->linkedToTeamMember($userId)->count();
        }

        return $counts;
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
        ]);

        if ($data['billing_level'] ?? null) {
            ProjectMeta::updateOrCreate(
                [
                    'key' => config('project.meta_keys.billing_level.key'),
                    'project_id' => $project->id,
                ],
                [
                    'value' => $data['billing_level'],
                ]
            );
        }

        $this->saveOrUpdateProjectContract($data, $project);
        if ($data['status'] == 'active' || $data['status'] == 'halted') {
            $project->client->update(['status' => 'active']);
        } else {
            if (! $project->client->projects()->where('status', 'active')->exists()) {
                $project->client->update(['status' => 'inactive']);
            }
            $project->getTeamMembers()->update(['ended_on' => now()]);
        }

        $project->is_ready_to_renew ? $project->tag('get-renewed') : $project->untag('get-renewed');

        $invoiceTerms = $data['invoiceTerms'] ?? [];
        $this->updateInvoiceTerms($invoiceTerms, $project);

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
                    'billing_engagement' => $teamMemberData['billing_engagement'],
                ]);
            }
        }
    }

    private function updateInvoiceTerms($invoiceTerms, $project)
    {
        if (empty($invoiceTerms)) {
            $project->invoiceTerms()->delete();

            return;
        }

        $existingTerms = $project->invoiceTerms()->get()->keyBy('id');

        $termIds = [];
        foreach ($invoiceTerms as $index => $term) {
            $termId = $term['id'] ?? null;

            if ($termId && isset($existingTerms[$termId])) {
                $existingTerm = $existingTerms[$termId];
                $filePath = $existingTerm->delivery_report;

                if (isset($term['delivery_report'])) {
                    $filePath = $this->saveOrUpdateDeliveryReport($term, $project, $index);
                }

                $existingTerm->update([
                    'invoice_date' => $term['invoice_date'],
                    'amount' => $term['amount'],
                    'report_required' => $term['report_required'] ?? $existingTerm->report_required,
                    'client_acceptance_required' => $term['client_acceptance_required'] ?? $existingTerm->client_acceptance_required,
                    'is_accepted' => $term['is_accepted'] ?? $existingTerm->is_accepted,
                    'delivery_report' => $filePath,
                ]);
                if(isset($term['comment'])){
                    $this->addCommentOnInvoiceTerm($term, $existingTerm);
                }
                $termIds[] = $termId;
            } else {
                $filePath = $this->saveOrUpdateDeliveryReport($term, $project, $index);
                $newTerm = $project->invoiceTerms()->create([
                    'project_id' => $project->id,
                    'invoice_date' => $term['invoice_date'],
                    'status' => 'yet-to-be-created',
                    'amount' => $term['amount'],
                    'report_required' => $term['report_required'] ?? false,
                    'client_acceptance_required' => $term['client_acceptance_required'] ?? false,
                    'is_accepted' => $term['is_accepted'] ?? false,
                    'delivery_report' => $filePath,
                ]);

                $termIds[] = $newTerm->id;
            }
        }

        $project->invoiceTerms()->whereNotIn('id', $termIds)->delete();
    }

    public function addCommentOnInvoiceTerm ($term, $existingTerm)
    {
        if($term['comment']){
            $comment = Comment::create([
                'user_id' => auth()->id(),
                'body' => $term['comment'],
                'commentable_id' => $existingTerm->id,
                'commentable_type' => ProjectInvoiceTerm::class,
            ]);
            $existingTerm->comments()->save($comment);
        }
        return;
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

    private function updateProjectTechstack($data, $project)
    {
        foreach ($data as $key => $value) {
            ProjectMeta::updateOrCreate(
                [
                    'key' => $key,
                    'project_id' => $project->id,
                ],
                [
                    'value' => $value,
                ]
            );
        }
    }

    private function updateProjectRequirement($data, $project)
    {
        if (isset($data['designation'])) {
            $needed = $data['needed'];

            $designationMap = config('project.designation');
            $projectId = $project->id;

            foreach ($designationMap as $key => $value) {
                $projectResourceRequirement = ProjectResourceRequirement::where([
                    ['project_id', '=', $projectId],
                    ['designation', '=', $key],
                ])->first();

                if (empty($needed[$key])) {
                    $needed[$key] = 0;
                }

                if ($projectResourceRequirement === null) {
                    $requirement = new ProjectResourceRequirement();
                    $requirement->project_id = $projectId;
                    $requirement->designation = $key;
                    $requirement->total_requirement = $needed[$key];
                    $requirement->save();
                } else {
                    $projectResourceRequirement->total_requirement = $needed[$key];
                    $projectResourceRequirement->save();
                }
            }
        }
    }

    private function getClientProjectID($clientID)
    {
        $client = Client::find($clientID);
        $clientProjectsCount = $client->projects->count() ?: 0;
        $clientProjectsCount += 1;

        return sprintf('%03s', $clientProjectsCount);
    }

    private function formatProjectFTEFOrExportAll($employees, $startDate, $endDate)
    {
        $teamMembers = [];
        foreach ($employees as $employee) {
            if (! $employee->user) {
                continue;
            }
            foreach ($employee->user->activeProjectTeamMembers as $activeProjectTeamMember) {
                $teamMember = [
                    $employee->name,
                    number_format($employee->getFtes($startDate, $endDate)['main'], 2),
                    $activeProjectTeamMember->project->name,
                    number_format($activeProjectTeamMember->getFte($startDate, $endDate), 2),
                    number_format($activeProjectTeamMember->getCommittedEfforts($startDate, $endDate), 2),
                    number_format($activeProjectTeamMember->getActualEffortBetween($startDate, $endDate, 'actual_effort'), 2),
                ];
                $teamMembers[] = $teamMember;
            }
        }

        return $teamMembers;
    }
}
