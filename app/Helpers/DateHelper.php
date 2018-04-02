<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
	/**
	 * Formats date string in 'd/m/Y' format to 'Y-m-d' format for storage
	 *
	 * @param  string $date
	 * @return string
	 */
	public static function formatDateToSave($date)
	{
		return Carbon::parse(str_replace('/', '-', $date))
		       ->format(config('constants.date_format'));
	}
}
