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
        $cube_js_response = Http::get('http://localhost:4000/cubejs-api/v1/load?query={"measures":["HrJobs.count"]}')->json();
        $data['totalWorkingDays'] = $cube_js_response['data']['0']['HrJobs.count'];

        return view('efforttracking::show')->with($data);
    }
}
