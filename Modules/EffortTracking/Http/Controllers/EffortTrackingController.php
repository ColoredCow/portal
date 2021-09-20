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
        $users = [];
        foreach ($teamMembers as $teamMember) {
            $userDetails = $teamMember->getUserDetails;
            $efforts = $teamMember->getMemberEffort()->get();
            foreach ($efforts as $effort) {
                $teamMembersEffort[$userDetails->id][$effort->id]['name'] = $userDetails->name;
                $teamMembersEffort[$userDetails->id][$effort->id]['actual_effort'] = $effort->actual_effort;
                $teamMembersEffort[$userDetails->id][$effort->id]['total_effort_in_effortsheet'] = $effort->total_effort_in_effortsheet;
                $teamMembersEffort[$userDetails->id][$effort->id]['added_on'] = $effort->added_on;
            }
            $users[] = [
                'id' => $userDetails->id,
                'name' => $userDetails->name,
                'actual_effort' => end($teamMembersEffort[$userDetails->id])['total_effort_in_effortsheet'],
            ];
        }
        $workingDays = self::countWorkingDays();

        return view('efforttracking::show')->with(['project' => $project, 'teamMembersEffort' => json_encode($teamMembersEffort), 'users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('efforttracking::edit');
    }

    public static function countWorkingDays()
    {
        $period = CarbonPeriod::create('2018-06-14', '2018-06-20');
        foreach ($period as $date) {
            echo $date->format('Y-m-d');
        }
        $dates = $period->toArray();
    }
}
