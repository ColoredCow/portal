<?php

namespace Modules\HR\Emails\Recruitment\Application;

use Modules\HR\Entities\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationHandover extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application, $userName)
    {
        $this->userName = $userName;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'), config('hr.default.name'))
            ->subject('Application handover')
            ->view('mail.hr.application-handover-request-email');
    }
}
