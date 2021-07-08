<?php

namespace Modules\HR\Observers\Recruitment;

use Modules\HR\Entities\Job;
use Modules\HR\Entities\Round;

class JobObserver
{
    /**
     * Listen to the Job create event.
     *
     * @param  \Modules\HR\Entities\Job  $job
     * @return void
     */
    public function created(Job $job)
    {
        $job->rounds()->attach(Round::all()->pluck('id')->toArray());
    }
}
