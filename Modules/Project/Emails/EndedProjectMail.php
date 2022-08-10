<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndedProjectMail extends Mailable implements ShouldQueue
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
        foreach ($this->projectData as $project) {
        }
        return $this
         ->to($project['email'])
         ->subject('ColoredCow Portal - Some of your projects are ended but still marked as active')
         ->view('project::mail.ended-project')
         ->with(['$projectData' => $project]);
    }
}
