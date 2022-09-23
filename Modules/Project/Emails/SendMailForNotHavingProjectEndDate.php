<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailForNotHavingProjectEndDate extends Mailable
{
    use Queueable, SerializesModels;

    protected $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('anshikagupta45612@gmail.com')
        ->to($this->project->client->keyAccountManager->email)
        ->subject('ColoredCow Portal - Fixed Budget Project is not having an end date')
        ->view('project::mail.not-having-project-end-date')
        ->with(['project' => $this->project]);
    }
}
