<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Exception;

class EffortReportController extends Controller
{
    public function barGraph(Request $request, $userId)
    {
        $employee = User::find($userId);
        try {
            $projectTeamMembers = $employee->projectTeamMembers;
            if ($projectTeamMembers == null) {
                throw new Exception('Error Processing Request');
            }
        } catch (Exception $e) {
            return 'The user does not have any project.';
        }

        $result = [];

        $start = today()->subDays(7);
        $end = today();
        $dates = [];

        for ($i = 0; $i < $end->diffInDays($start); $i++) {
            $dates[] = (clone $start)->subDays($i)->format('Y-m-d');
        }

        $color = config('constants.bar-Chart-Colors');
        $colors = array_values($color);

        foreach ($projectTeamMembers as $projectTeamMember) {
            foreach ($dates as $date) {
                $result[$projectTeamMember->project->name][$date] = ProjectTeamMemberEffort::whereDate('added_on', $date)
                    ->where('project_team_member_id', $projectTeamMember->team_member_id)->sum('actual_effort');
            }
        }
        
        $projectNames = array_keys($result);
        $efforts = [];

        foreach ($projectNames as $projectName) {
            $projectEffort = [];
            foreach ($dates as $date) {
                $projectEffort[] = $result[$projectName][$date];
            }

            $efforts[] = $projectEffort;
        }

        $chartData = [
            'labels' => $dates,
            'colors' => $colors,
            'projects' => $projectNames,
            'efforts' => $efforts
        ];

        return view('hr.effort.bar-graph', ['employee' => $employee, 'chartData' => json_encode($chartData)]);
    }
}
