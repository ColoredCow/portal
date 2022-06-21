<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;

class ZeroEffortInProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $zeroEffortInProject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $zeroEffortInProject)
    {
        $this->zeroEffortInProject = $zeroEffortInProject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        foreach ($this->zeroEffortInProject as $projectManager) {
            return $this
            ->to($projectManager['projectManagerEmail'])
            ->subject('Zero Effort for team members')
            ->view('project::mail.zero-effort-team-member-list')
            ->with(['projectManager' => $projectManager]);
        }
    }
}
