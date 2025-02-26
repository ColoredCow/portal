<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EffortsheetSetupMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $project;
    public $emails = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project, array $emails)
    {
        $this->project = $project;
        $this->emails = $emails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject("Project Effortsheet Setup Request: {$this->project->name}")
                    ->from(config('mail.from.address'))
                    ->to($this->emails['infrasupport_email'])
                    ->cc($this->emails['key_account_manager'])
                    ->view('project::mail.effortsheet-setup-email')
                    ->with([
                        'project' => $this->project,
                    ]);

        return $mail;
    }
}
