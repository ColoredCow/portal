<?php

namespace Modules\HR\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetainershipAgreement extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $fileName)
    {
        $this->name = $name;
        $this->email = $email;
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Retainership Agreement - ' . $this->name)
            ->to($this->email)
            ->view('hr::mail.offer-letter-to-new-joinee')
            ->attach(storage_path('app/public/' . config('constants.hr.offer-letters-dir') . '/' . $this->fileName));
    }
}