<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EndedProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $projectsData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $projectsData)
    {
        $this->$projectsData = $projectsData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build($projectsData)
    {
        return $this
        ->to($this->$projectsData['email'])
        ->subject('ColoredCow Portal - Some of your projects are ended but still marked as active')
        ->view('project::mail.ended-project')
        ->with(['$projectsData' => $this->$projectsData]);
    }
}

