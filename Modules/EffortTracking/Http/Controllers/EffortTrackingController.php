<?php

namespace Modules\EffortTracking\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Modules\EffortTracking\Services\EffortTrackingService;
use Modules\Project\Entities\Project;

class EffortTrackingController extends Controller
{
    protected $service;

    public function __construct(EffortTrackingService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the specified resource.
     * @param Project $project
     */
    public function show(Project $project)
    {
        $data = $this->service->show($project);
        $cube_js_response = Http::get('http://localhost:4000/cubejs-api/v1/load?query={"measures":["ProjectTeamMembersEffort.project_monthly_hours"],"timeDimensions":[{"dimension":"ProjectTeamMembersEffort.createdAt","granularity":"month"}],"order":{"ProjectTeamMembersEffort.createdAt":"asc"},"filters":[{"member":"ProjectTeamMembers.project_id","operator":"equals","values":["' . $project->id . '"]}]}')->json();

        return view('efforttracking::show')->with($data);
    }
}
