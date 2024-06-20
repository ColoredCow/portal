<?php

namespace Modules\Project\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Client\Entities\Client;
use Modules\EffortTracking\Services\EffortTrackingService;
use Modules\HR\Entities\HrJobDomain;
use Modules\HR\Entities\Job;
use Modules\Project\Contracts\ProjectServiceContract;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectContract;
use Modules\Project\Http\Requests\ProjectRequest;
use Modules\Project\Rules\ProjectNameExist;
use Modules\Project\Services\ProjectService;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    protected $service;
    protected $projectService;

    public function __construct(ProjectServiceContract $service, ProjectService $projectService)
    {
        $this->authorizeResource(Project::class);
        $this->service = $service;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->service->index(request()->all());

        return view('project::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = $this->service->getClients($status = 'all');

        return view('project::create')->with('clients', $clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     */
    public function store(ProjectRequest $request)
    {
        $validated = $request->validated();
        $this->service->store($validated);

        return redirect(route('project.index'))->with('success', 'Project has been created successfully!');
    }

    /**
     * Show the specified resource.
     *
     * @param Project $project
     */
    public function show(Request $request, Project $project)
    {
        $contractData = $this->getContractData($project);
        $contract = $contractData['contract'];
        $contractFilePath = $contractData['contractFilePath'];
        $contractName = $contractData['contractName'];
        $currentDate = today(config('constants.timezone.indian'));

        if (now(config('constants.timezone.indian'))->format('H:i:s') < config('efforttracking.update_date_count_after_time')) {
            $currentDate = $currentDate->subDay();
        }
        $daysTillToday = count($project->getWorkingDaysList($project->client->month_start_date, $currentDate));

        $effortTracking = new EffortTrackingService;
        $isApprovedWorkPipelineExist = $effortTracking->getIsApprovedWorkPipelineExist($project->effort_sheet_url);

        $getProjectHourDeatils = $this->service->getProjectApprovedPipelineHour($project);

        $monthlyApprovedHour = $getProjectHourDeatils['monthlyApprovedHour'];
        $totalEffort = $project->getTotalEffort();
        $dailyEffort = $project->getDailyTotalEffort();
        $totalExpectedHourInMonth = $getProjectHourDeatils['totalExpectedHourInMonth'];
        $totalWeeklyEffort = $getProjectHourDeatils['totalWeeklyEffort'];
        $remainingApprovedPipeline = $getProjectHourDeatils['remainingApprovedPipeline'];
        $remainingExpectedEffort = $getProjectHourDeatils['remainingExpectedEffort'];
        $weeklyHoursToCover = $getProjectHourDeatils['weeklyHoursToCover'];
        $effortData = $effortTracking->show($request->all(), $project);

        return view('project::show', [
            'project' => $project,
            'contract' => $contract,
            'contractFilePath' => $contractFilePath,
            'contractName' => $contractName,
            'daysTillToday' => $daysTillToday,
            'isApprovedWorkPipelineExist' => $isApprovedWorkPipelineExist,
            'totalExpectedHourInMonth' => $totalExpectedHourInMonth,
            'monthlyApprovedHour' => $monthlyApprovedHour,
            'totalWeeklyEffort' => $totalWeeklyEffort,
            'remainingApprovedPipeline' => $remainingApprovedPipeline,
            'remainingExpectedEffort' => $remainingExpectedEffort,
            'weeklyHoursToCover' => $weeklyHoursToCover,
            'effortData' => $effortData,
            'totalEffort' => json_encode($totalEffort),
            'dailyEffort' => $dailyEffort,
            'stages' => $this->projectService->getProjectStages($project),
        ]);
    }

    public function destroy(ProjectRequest $request, Project $project)
    {
        $project->update(
            [
                'reason_for_deletion' => $request['comment'],
            ]
        );
        $project->delete();

        return redirect()->back()->with('status', 'Project deleted successfully!');
    }

    public static function showPdf(ProjectContract $contract)
    {
        $filePath = storage_path('app/' . $contract->contract_file_path);
        $content = file_get_contents($filePath);
        $contractFileName = pathinfo($contract->contract_file_path)['filename'];

        return response($content)->withHeaders([
            'content-type' => mime_content_type($filePath),
            'contractFileName' => $contractFileName,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Project $project
     */
    public function edit(Project $project)
    {
        $designations = $this->service->getDesignations();
        $designationKeys = array_keys($designations);
        $contractData = $this->getContractData($project);
        $contractName = $contractData['contractName'];

        return view('project::edit', [
            'project' => $project,
            'clients' => Client::orderBy('name')->get(),
            'teamMembers' => $this->service->getTeamMembers(),
            'projectTeamMembers' => $this->service->getProjectTeamMembers($project),
            'projectRepositories' => $this->service->getProjectRepositories($project),
            'designations' => $designations,
            'workingDaysInMonth' => $this->service->getWorkingDays($project),
            'designationKeys' => $designationKeys,
            'contractName' => $contractName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $request->merge([
            'name' => trim(preg_replace('/\s\s+/', ' ', str_replace("\n", ' ', $request->name))),
        ]);
        if ($request->name != $project->name) {
            $request->validate(['name' => new ProjectNameExist()]);
        }

        return $this->service->updateProjectData($request->all(), $project);
    }

    public function projectFTEExport(Request $request)
    {
        $filters = $request->all();

        return $this->service->projectFTEExport($filters);
    }

    public function projectResource()
    {
        $resourceData = $this->service->getProjectsWithTeamMemberRequirementData(request()->all());
        $domainName = HrJobDomain::all();
        $jobName = Job::all();

        return view('project::resource-requirement', [
            'resourceData' => $resourceData,
            'domainName' => $domainName,
            'jobName' => $jobName,
        ]);
    }

    public function manageStage(Request $request)
    {
        $validatedData = $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'newStages' => 'nullable|array',
            'newStages.*.stage_name' => 'required|string',
            'newStages.*.comments' => 'nullable|string',
            'newStages.*.status' => 'nullable|string',
            'deletedStages' => 'nullable|array',
            'deletedStages.*' => 'required|integer|exists:project_old_stages,id',
            'updatedStages' => 'nullable|array',
            'updatedStages.*.id' => 'required|integer|exists:project_old_stages,id',
        ]);

        if (empty($validatedData['deletedStages']) && empty($validatedData['newStages']) && empty($validatedData['updatedStages'])) {
            return response()->json([
                'status' => 400,
                'error' => 'No New Changes Detected',
            ], 400);
        }

        if (! empty($validatedData['deletedStages'])) {
            $this->projectService->removeStage($validatedData['deletedStages']);
        }

        if (! empty($validatedData['newStages'])) {
            $this->projectService->storeStage($validatedData['newStages'], $validatedData['project_id']);
        }

        if (! empty($validatedData['updatedStages'])) {
            $this->projectService->updateStage($validatedData['updatedStages']);
        }

        return response()->json([
            'status' => 200,
            'success' => 'Stages managed successfully!',
        ]);
    }

    // storing Contract related data here
    private function getContractData(Project $project)
    {
        $contract = ProjectContract::where('project_id', $project->id)->first();
        $contractFilePath = $contract ? storage_path('app/' . $contract->contract_file_path) : null;
        $contractName = basename($contractFilePath);

        return [
            'contract' => $contract,
            'contractFilePath' => $contractFilePath,
            'contractName' => $contractName,
        ];
    }
}
