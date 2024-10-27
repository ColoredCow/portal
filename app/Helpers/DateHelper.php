<?php
namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    /**
     * Formats date string in 'd/m/Y' format to 'Y-m-d' format for storage.
     *
     * @param  string $date
     *
     * @return string
     */
    public static function formatDateToSave($date)
    {
        return Carbon::parse(str_replace('/', '-', $date))
               ->format(config('constants.date_format'));
    }

    /**
     * Get an array of month details. Returns month number, name and year for that month.
     *
     * @param  int $count    the number of previous months from today to retrieve
     *
     * @return array
     */
    public static function getPreviousMonths($count)
    {
        $monthsList = [];
        $date = new Carbon('first day of this month');
        for ($index = 0; $index <= $count; $index++) {
            $monthsList[] = [
                'id' => $date->format('m'),
                'name' => $date->format('F'),
                'year' => $date->format('Y'),
            ];
            $date = $date->subMonth();
        }

        return $monthsList;
    }
}
