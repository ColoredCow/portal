<?php

namespace Modules\EffortTracking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
     *
     * @param Project $project
     */
    public function show(Request $request, Project $project)
    {
        $data = $this->service->show($request->all(), $project);

        return view('efforttracking::show')->with($data);
    }

    /**
     * Refresh the efforts of the project team members.
     *
     * @param Project $project
     */
    public function getEffortForProject(Request $request, Project $project)
    {
        $syncParams = $request->validate([
            'isBackDateSync' => 'required',
        ]);

        if ($this->service->getEffortForProject($project, $syncParams)) {
            return response()->json(['message' => 'Effort updated successfully'], 200);
        }

        return response()->json(['message' => 'Error occurred'], 404);
    }
}
