<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendThreshholdFollowUp extends Mailable
{
    use Queueable, SerializesModels;

    public $applications;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applications, $user)
    {
        // dd($user);
        $this->applications = $applications;
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
            ->subject('Follow up with applicants through a phone call')
            ->view('hr::application.followups');
    }
}
