<?php

namespace App\Mail\HR;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;
use Modules\User\Entities\User;

class SendForApproval extends Mailable
{
    use Queueable, SerializesModels;

    public $approver;
    public $mailTemplate;

    /**
     * Create a new message instance.
     *
     * @param User        $supervisor
     * @param Application $application
     */
    public function __construct(User $approver, $mailTemplate)
    {
        $this->approver = $approver;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->approver->email, $this->approver->name)
            ->from(config('constants.hr.default.email'), config('constants.hr.default.name'))
            ->subject(config('app.name') . ' – NDA request for approval')
            ->view('legaldocument::nda.communications.mails.template.send-to-approver')
            ->with([
                'mailTemplate' => $this->mailTemplate,
            ]);
    }
}
