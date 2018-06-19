<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Retrieve file path based upon year and month
     *
     * @param  string $year  year directory of the file
     * @param  string $month month directory of the file
     * @param  string $file  invoice file name
     * @return string
     */
    public static function getFilePath($year, $month, $file)
    {
        $filePath =  $year . '/' . $month . '/' . $file;

        if (!Storage::exists($filePath)) {
            return false;
        }

        return $filePath;
    }

    /**
     * Retrieve storage directory based upon current year and month
     *
     * @return string
     */
    public static function getCurrentStorageDirectory()
    {
        $now = Carbon::now();
        return $now->format('Y') . '/' . $now->format('m');
    }
}
