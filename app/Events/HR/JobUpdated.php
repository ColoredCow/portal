<?php

namespace App\Events\HR;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class JobUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $job;
    public $attr;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Job $job, $attr = [])
    {
        $this->job = $job;
        $this->attr = $attr;
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
