<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EndedProjectMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $projectData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($projectData)
    {
        $this->projectData = $projectData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('ColoredCow Portal - Some of your projects are ended but still marked as active');
        foreach ($this->projectData as $project) {
            $mail->to($project['email']);
        }

        return $mail->view('project::mail.ended-project');
    }
}
