<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;

class ZeroEffortInProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $projectManager;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $projectManager)
    {
        $this->projectManager = $projectManager;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->to($this->projectManager['projectManagerEmail'])
        ->subject('Zero Effort for team members')
        ->view('project::mail.zero-effort-team-member-list')
        ->with(['projectManager' => $this->projectManager]);
    }
}
