<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyEffortsNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $users;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->to($this->users['email'])
        ->subject('ColoredCow Portal - you are putting less efforts than actual in project!')
        ->view('mail.effort.daily-effort-alert')
        ->with(['users' => $this->users]);
    }
}
