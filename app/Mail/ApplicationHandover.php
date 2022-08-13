<?php

namespace App\Mail;

use Modules\HR\Entities\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationHandover extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Application $application, $requestedUser)
    {
        $this->application = $application;
        $this->user = $requestedUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->user->email)
            ->view('hr::application.application-handover-request');
    }
}