<?php
namespace Modules\HR\Listeners\Recruitment;

use Illuminate\Support\Facades\Artisan;

class MoveResumeToWebsite
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('hr:move-resume-to-website');
    }
}
