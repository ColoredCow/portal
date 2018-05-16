<?php

namespace App\Events\HR;

use App\Models\HR\Application;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $application;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return void
     */
    public function broadcastOn()
    {
        //
    }
}
