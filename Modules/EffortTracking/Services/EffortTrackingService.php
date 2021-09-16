<?php

namespace Modules\EffortTracking\Services;

// namespace Revolution\Google\Sheets;

use Revolution\Google\Sheets\Sheets;

class EffortTrackingService
{
    public static function sync()
    {
        // dd("inside service sync");

        // $user = auth()->user();

        // dd($user);

        // $token = [
        //     'access_token'  => $user->access_token,
        //     'refresh_token' => $user->refresh_token,
        //     'expires_in'    => $user->expires_in,
        //     'created'       => now()->getTimestamp(),
        // ];

        // dd($token);

        $spreadSheetId = '1g4kGalUsI-78MNJo1EyPbok5-P28fbbc2vjB-fK1XOo';
        $sheetName = 'September, 2021';

        $sheet = new Sheets();

        $range = 'C2:G6'; // this will depend on the number of people on the project

        $sheets = $sheet->spreadsheet($spreadSheetId)
                        ->sheet($sheetName)
                        ->range($range)
                        ->get();

        // this will return a structure like this
        //     0 => array:5 [▼
        //     0 => "Shamoon"    // name of the team member
        //     1 => "September 1, 2021" // Start of the month
        //     2 => "September 30, 2021" // End of the month
        //     3 => "6" // Total working days
        //     4 => "48" // Total hours put in the month
        //   ]

        // loop over each person in the project and add his hours in the database
        foreach ($sheets as $row) {
            dd($row);
        }

        // $values = $sheet->setAccessToken($token)->spreadsheet($spreadSheetId)->sheet($sheetName)->all();
        // dd($values);
    }
}
