<?php

namespace App\Mail\HR;

use App\Models\HR\Application;
use Modules\User\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendForApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $supervisor;
    public $application;

    /**
     * Create a new message instance.
     *
     * @param User        $supervisor
     * @param Application $application
     */
    public function __construct(User $supervisor, Application $application)
    {
        $this->supervisor = $supervisor;
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->supervisor->email, $this->supervisor->name)
            ->from(config('constants.hr.default.email'), config('constants.hr.default.name'))
            ->subject(config('app.name') . ' – Application request for approval')
            ->view('mail.hr.send-for-approval')
            ->with([
                'application' => $this->application,
                'supervisor' => $this->supervisor,
            ]);
    }
}
