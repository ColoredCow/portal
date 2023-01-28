<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ZeroExpectedHourInProjectMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $projectDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projectDetails)
    {
        $this->projectDetails = $projectDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('ColoredCow Portal - Some of your projects have zero expeced hours');
        $mail->to($this->projectDetails['email']);

        return $mail->view('project::mail.zero-expected-hours-in-project');
    }
}
