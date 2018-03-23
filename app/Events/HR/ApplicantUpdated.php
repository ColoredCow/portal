<?php

namespace App\Events\HR;

use App\Models\HR\Applicant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicantUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $applicant;
    public $attr;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Applicant $applicant, $attr = [])
    {
        $this->applicant = $applicant;
        $this->attr = $attr;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //
    }
}
