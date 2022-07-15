<?php

namespace Modules\HR\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\HR\Events\Recruitment\ApplicantEmailVerified;
use Modules\HR\Events\Recruitment\ApplicationCreated;
use Modules\HR\Events\Recruitment\JobUpdated;
use Modules\HR\Listeners\Recruitment\ApplicantEmailVerification;
use Modules\HR\Listeners\Recruitment\AutoRespondApplicant;
use Modules\HR\Listeners\Recruitment\CreateFirstApplicationRound;
use Modules\HR\Listeners\Recruitment\MoveResumeToWebsite;
use Modules\HR\Listeners\Recruitment\UpdateJobRounds;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Modules\HR\Events\ApplicationMovedToNewRound' => [
            'Modules\HR\Listeners\SendCustomApplicationMail'
        ],

        'Modules\HR\Events\CustomMailTriggeredForApplication' => [
            'Modules\HR\Listeners\SendCustomApplicationMail'
        ],

        'Modules\HR\Events\InterviewCommunicationEmailSent' => [
            'Modules\HR\Listeners\AppointmentSlotMailSent'
        ],

        'Modules\HR\Events\FollowUpEvent' => [
            'Modules\HR\Listeners\FollowUpListener'
        ],

        ApplicationCreated::class => [
            CreateFirstApplicationRound::class,
            ApplicantEmailVerification::class,
            MoveResumeToWebsite::class,
        ],

        ApplicantEmailVerified::class => [
            AutoRespondApplicant::class,
        ],

        JobUpdated::class => [
            UpdateJobRounds::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
