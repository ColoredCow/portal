<?php

namespace Modules\HR\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Carbon\Carbon;
use Exception;

class EffortReportController extends Controller
{
    public function barGraph(Request $request, $employeeId)
    {
        $employee = User::find($employeeId);
        try {
            $projectTeamMembers = $employee->projectTeamMembers;
            if ($projectTeamMembers == null) {
                throw new Exception('Error Processing Request');
            }
        } catch (Exception $e) {
            return '<h1>TeamMember not found please add a new teammember</h1>';
        }

        $result = [];

        $start = Carbon::now()->addDays(-7);
        $end = Carbon::now();
        $dates = [];

        for ($i = 0; $i < $end->diffInDays($start); $i++) {
            $dates[] = (clone $start)->addDays($i)->format('Y-m-d');
        }

        $color = ['#ff0080', '#00bfff', '#ffff00'];

        foreach ($projectTeamMembers as $projectTeamMember) {
            foreach ($dates as $date) {
                $result[$projectTeamMember->project->name][$date] = ProjectTeamMemberEffort::whereDate('added_on', $date)
                    ->where('project_team_member_id', $projectTeamMember->team_member_id)->sum('actual_effort');
            }
        }

        $projectNames = array_keys($result);
        $efforsts = [];

        foreach ($projectNames as $projectName) {
            $projectEffort = [];
            foreach ($dates as $date) {
                $projectEffort[] = $result[$projectName][$date];
            }

            $efforsts[] = $projectEffort;
        }

        $chartData = [
            'labels' => $dates,
            'colors' => $color,
            'projects' => $projectNames,
            'efforts' => $efforsts
        ];

        return view('hr.effort.bar-graph', ['employee' => $employee, 'projectTeamMembers' => $projectTeamMembers])->with([
            'chartData' => json_encode($chartData)
        ]);
    }
}
