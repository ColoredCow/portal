<?php

namespace App\Observers\HR;

use App\Mail\HR\Applicant\NoShow;
use App\Models\HR\ApplicationMeta;
use Illuminate\Support\Facades\Mail;

class ApplicationMetaObserver
{
    /**
     * Listen to the ApplicationMeta create event
     * @param  ApplicationMeta $applicationMeta
     * @return void
     */
    public function created(ApplicationMeta $applicationMeta)
    {
        $application = $applicationMeta->application;

        switch ($applicationMeta->key) {
            case config('constants.hr.status.no-show.label'):
                //$application->markNoShowReminded();
                Mail::send(new NoShow($applicationMeta));
                
                break;
        }
    }
}
