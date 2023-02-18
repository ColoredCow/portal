<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FixedBudgetProjectMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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
        $mail = $this->subject('ColoredCow Portal - Some of your fixed budget projects are about to end');
        foreach ($this->projectData as $project) {
            $mail->to($project['email']);
        }

        return
        $mail->view('project::mail.fixed-budget-project');
    }
}
