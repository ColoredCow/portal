<?php

namespace Modules\EffortTracking\Services;

// namespace Revolution\Google\Sheets;

use Modules\Project\Entities\Project;
use Revolution\Google\Sheets\Sheets;

class EffortTrackingService
{
    public static function sync()
    {

        // Fetch all projects

        $projects = Project::where('status', 'active')->get();

        // loop over each project

        foreach ($projects as $project) {
            $effortSheetURL = $project->effort_sheet_url;

            // $spreadSheetId = '1g4kGalUsI-78MNJo1EyPbok5-P28fbbc2vjB-fK1XOo'; // need to get from project efforstsheet url

            $matchesId = [];
            preg_match('/.*[^-\w]([-\w]{25,})[^-\w]?.*/', $effortSheetURL, $matchesId);

            $spreadSheetId = $matchesId[1];

            $sheetName = '756414304'; // get from efforstsheet url
            // $sheetName =

            $sheet = new Sheets();

            $range = 'C2:G6'; // this will depend on the number of people on the project

            $sheets = $sheet->spreadsheet($spreadSheetId)
                            ->sheetById($sheetName)
                            ->range($range)
                            ->get();

            // this will return a structure like this
            //     0 => array:5 [
            //     0 => "Shamoon"    // name of the team member
            //     1 => "September 1, 2021" // Start of the month
            //     2 => "September 30, 2021" // End of the month
            //     3 => "6" // Total working days
            //     4 => "48" // Total hours put in the month
            //   ]
            dd($sheets);

            // loop over each person in the project and add his hours in the database
            foreach ($sheets as $user) {

                // get user in portal from the name of the user in effortsheet

                // insert into project_team_member_effort
            }
        }

        // $values = $sheet->setAccessToken($token)->spreadsheet($spreadSheetId)->sheet($sheetName)->all();
        // dd($values);
    }
}
