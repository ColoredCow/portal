<?php

namespace Modules\EffortReport\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\Employee;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\Project\Entities\project;
use Modules\EffortReport\Entities\EmployeeEffort;
use Modules\User\Entities\User;
use Modules\Project\Entities\ProjectTeamMemberEffort;
use Carbon\Carbon;

class EffortReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function barGraph(Request $request, $employeeId)
    {
        $employee = User::find($employeeId);
        $projectTeamMembers = $employee->projectTeamMembers;
        $result = [];

        $start = Carbon::now()->addDays(-7);
        $end = Carbon::now();
        $dates = [];
        for($i = 0; $i < $end->diffInDays($start); $i++){
            $dates[] = (clone $start)->addDays($i)->format('Y-m-d');
        }
        $color = ['#ff0080', '#00bfff', '#ffff00'];
       
        foreach($projectTeamMembers as $projectTeamMember)
        {
            foreach($dates as $date)
            {
                $result[$projectTeamMember->project->name][$date] = projectTeamMemberEffort::whereDate('added_on', $date)
                ->where('project_team_member_id', $projectTeamMember->team_member_id)->sum('actual_effort');
            }
        }

        $projectNames =  array_keys($result);

        $efforsts = [];

        foreach($projectNames as $projectName) {
            $projectEffort = [];
            foreach($dates as $date) {
              $projectEffort[] = $result[$projectName][$date];  
            }

            $efforsts[] = $projectEffort;
        }

        $chartData = array(
        'labels' => $dates,
        'colors' => $color,
        'projects' => $projectNames,
        'efforts' => $efforsts
        );
        return view('effortreport::bar-graph', ['employee' => $employee, 'chartData' => $chartData]);
    }
}
