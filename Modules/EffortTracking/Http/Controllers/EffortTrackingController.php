<?php

namespace Modules\EffortTracking\Http\Controllers;

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
        $totalEffort = 0;
        $workingDays = self::countWorkingDays(now()->startOfMonth(), now());
        $totalWorkingDays = count(self::countWorkingDays(now()->startOfMonth(), now()->endOfMonth()));
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
                'color' => self::random_color(),
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

        return view('efforttracking::show')->with(['project' => $project, 'teamMembersEffort' => json_encode($teamMembersEffort), 'users' => json_encode($users), 'workingDays' => json_encode($workingDays), 'totalWorkingDays' => $totalWorkingDays, 'totalEffort' => $totalEffort, 'projectFTE' => $projectFTE]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('efforttracking::edit');
    }

    public static function countWorkingDays($startDate, $endDate)
    {
        $period = CarbonPeriod::create($startDate, $endDate);
        $dates = [];
        foreach ($period as $date) {
            if ($date->format('l') !== 'Saturday' && $date->format('l') !== 'Sunday') {
                $dates[] = $date->format('Y-m-d');
            }
        }

        return $dates;
    }

    public static function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public static function random_color()
    {
        return '#' . self::random_color_part() . self::random_color_part() . self::random_color_part();
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
