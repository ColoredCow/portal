<?php
namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentSlotSelectionMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $mailData = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->mailData['subject'])
            ->view('mail.plain', ['body' => $this->mailData['body']]);
    }
}
