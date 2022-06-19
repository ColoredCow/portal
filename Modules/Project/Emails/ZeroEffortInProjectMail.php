<?php

namespace Modules\Project\Emails;

use Google\Service\ShoppingContent\Resource\Collections;
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
        if(! $this->zeroEffortInProject->isEmpty()){
            dd($this->zeroEffortInProject);
            foreach ($this->zeroEffortInProject as $projectManager) {
                $projectManagerEmail = implode(',', $projectManager['projectManagerEmail']);

                return $this
                ->to($projectManagerEmail)
                ->subject('Zero Effort for team members')
                ->view('project::mail.zero-effort-team-member-list')
                ->with(['projectManager' => $projectManager]);
            }
        } 
    }
}