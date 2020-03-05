<?php

namespace App\Services;

use App\Models\Project\ProjectTimesheet;

class TimesheetService
{
    public function __construct()
    {
    }

    public function getMonthDates()
    {
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        $monthDates = [];
        while ($startDate->lte($endDate)) {
            $monthDates[] = ['label' => $startDate->format('d, D'), 'slug' => $startDate->format('d-D')];
            $startDate->addDay();
        }
        return $monthDates;
    }

    public function addNewModule(ProjectTimesheet $timesheet, $data) {
        $moduleName = $data['moduleName'];
        $subTasks = $data['subTasks'];
        $module = $timesheet->modules()->create(['name' => $moduleName]);
       // $module
       //$timesheet->addNewModule($data);
    }
}
