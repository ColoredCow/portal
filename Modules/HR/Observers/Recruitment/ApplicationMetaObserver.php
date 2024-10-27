<?php

namespace Modules\HR\Observers\Recruitment;

use Illuminate\Support\Facades\Mail;
use Modules\HR\Emails\Recruitment\Applicant\NoShow;
use Modules\HR\Entities\ApplicationMeta;

class ApplicationMetaObserver
{
    /**
     * Listen to the ApplicationMeta create event.
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
