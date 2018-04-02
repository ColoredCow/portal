<?php

use Carbon\Carbon;

if (!function_exists('format_date_to_save'))
{
	/**
	 * Formats date string in 'd/m/Y' format to 'Y-m-d' format for storage
	 *
	 * @param  string $date
	 * @return string
	 */
	function format_date_to_save($date)
	{
		return Carbon::parse(str_replace('/', '-', $date))
		       ->format(config('constants.date_format'));
	}
}

