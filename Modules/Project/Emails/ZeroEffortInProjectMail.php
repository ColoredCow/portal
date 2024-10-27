<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZeroEffortInProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    public $keyAccountManagerDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $keyAccountManagerDetails)
    {
        $this->keyAccountManagerDetails = $keyAccountManagerDetails;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('ColoredCow Portal - Some of your team members have zero effort in projects!');
        foreach ($this->keyAccountManagerDetails as $project) {
            $mail->to($project['email']);
        }

        return $mail->view('project::mail.zero-effort-team-member-list');
    }
}
