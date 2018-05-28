<?php

namespace App\Observers\HR;

use App\Models\HR\Job;
use App\Models\HR\Round;

class JobObserver
{
	/**
	 * Listen to the Job create event.
	 *
	 * @param  \App\Models\HR\Job  $job
	 * @return void
	 */
	public function created(Job $job)
	{
		$job->rounds()->attach(Round::all()->pluck('id')->toArray());
	}
}
