<?php

namespace Modules\EffortTracking\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Project\Entities\Project;

class EffortTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Project $project
     */
    public function index(Project $project)
    {
        return view('efforttracking::index')->with('project', $project);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('efforttracking::create');
    }

    /**
     * Show the specified resource.
     * @param Project $project
     */
    public function show(Project $project)
    {
        $teamMembers = $project->getTeamMembers()->get();
        $teamMembersEffort = [];
        foreach ($teamMembers as $teamMember) {
            $userDetails = $teamMember->getUserDetails;
            $efforts = $teamMember->getMemberEffort()->get();
            foreach ($efforts as $effort) {
                $teamMembersEffort['team_member_id'] = $teamMember->id;
                $teamMembersEffort['name'] = $userDetails->name;
                $teamMembersEffort['actual_effort'] = $effort->actual_effort;
                $teamMembersEffort['total_effort_in_effortsheet'] = $effort->total_effort_in_effortsheet;
            }
        }

        return view('efforttracking::show')->with(['project' => $project, 'teamMembersEffort' => json_encode($teamMembersEffort)]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('efforttracking::edit');
    }
}
