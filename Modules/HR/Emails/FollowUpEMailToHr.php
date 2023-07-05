<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowUpEMailToHr extends Mailable
{
    use Queueable, SerializesModels;

    public $filteredApplications;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filteredApplications, $user)
    {
        $this->filteredApplications = $filteredApplications;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('hr.default.email'), config('hr.default.name'))
            ->subject('Follow up mail to HR with applicants.')
            ->view('hr::application.followups-to-hr');
    }
}
