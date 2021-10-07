<?php

namespace Modules\EffortTracking\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
        $totalEffort = 0;
        $workingDays = self::countWorkingDays(now()->startOfMonth(), now());
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        $totalWorkingDays = count(self::countWorkingDays($startDate, $endDate));
        foreach ($teamMembers as $teamMember) {
            $userDetails = $teamMember->getUserDetails;
            $efforts = $teamMember->projectTeamMemberEffort()->get();
            foreach ($efforts as $effort) {
                $effortAddedOn = new Carbon($effort->added_on);
                $teamMembersEffort[$userDetails->id][$effort->id]['name'] = $userDetails->name;
                $teamMembersEffort[$userDetails->id][$effort->id]['actual_effort'] = $effort->actual_effort;
                $teamMembersEffort[$userDetails->id][$effort->id]['total_effort_in_effortsheet'] = $effort->total_effort_in_effortsheet;
                $teamMembersEffort[$userDetails->id][$effort->id]['added_on'] = $effortAddedOn->format('Y-m-d');
            }
            $users[] = [
                'id' => $userDetails->id,
                'name' => $userDetails->name,
                'actual_effort' => end($teamMembersEffort[$userDetails->id])['total_effort_in_effortsheet'],
                'expected_effort' => self::getExpectedHours(count($workingDays)),
                'FTE' => self::getFTE(end($teamMembersEffort[$userDetails->id])['total_effort_in_effortsheet'], self::getExpectedHours(count($workingDays))),
            ];
        }
        foreach ($teamMembersEffort as $key => $teamMemberEffort) {
            $totalTeamMemberEffort = end($teamMemberEffort)['total_effort_in_effortsheet'];
            $totalEffort += $totalTeamMemberEffort;
        }
        $expectedHours = self::getExpectedHours(count($workingDays));
        $projectFTE = self::getFTE($totalEffort, $expectedHours);

        return view('efforttracking::show')->with([
            'project' => $project,
            'teamMembersEffort' => json_encode($teamMembersEffort),
            'users' => json_encode($users),
            'workingDays' => json_encode($workingDays),
            'totalWorkingDays' => $totalWorkingDays,
            'totalEffort' => $totalEffort,
            'projectFTE' => $projectFTE,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
    }

    public static function countWorkingDays($startDate, $endDate)
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

    public static function getFTE($currentHours, $expectedHours)
    {
        return round($currentHours / $expectedHours, 2);
    }

    public static function getExpectedHours($numberOfDays)
    {
        return config('efforttracking.minimum_expected_hours') * $numberOfDays;
    }
}
