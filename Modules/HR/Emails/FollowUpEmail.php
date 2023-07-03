<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowUpEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $applications;
    public $user;
    /**
     * Create a new message instance.
     *
     * @param  array  $followUps
     * @return void
     */
    public function __construct(array $applications, $user)
    {
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
            ->subject('Follow up with applicants through a follow up mail')
            ->view('hr::application.follow_up');
    }
}
