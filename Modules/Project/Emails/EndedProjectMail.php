<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EndedProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $projectKeyAccountManager;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $projectKeyAccountManager)
    {
        $this->$projectKeyAccountManager = $projectKeyAccountManager;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build($projectKeyAccountManager)
    {
        return $this
        ->to($this->$projectKeyAccountManager['email'])
        ->subject('ColoredCow Portal - Some of your projects are ended but still marked as active')
        ->view('project::mail.ended-projects')
        ->with(['$projectKeyAccountManager' => $this->$projectKeyAccountManager]);
    }    
}
