<?php

namespace App\Observers\HR;

use App\Models\HR\ApplicationRound;
use App\Notifications\HR\ApplicationRoundScheduled;

class ApplicationRoundObserver
{
	/**
	 * Listen to the ApplicationRound created event.
	 *
	 * @param  \App\Models\HR\ApplicationRound  $applicationRound
	 * @return void
	 */
	public function created(ApplicationRound $applicationRound)
	{
		$applicationRound->load('application', 'scheduledPerson');
		if ($applicationRound->application->status != config('constants.hr.status.on-hold.label')) {
			$applicationRound->scheduledPerson->notify(new ApplicationRoundScheduled($applicationRound));
		}
	}
}
