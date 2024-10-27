<?php

namespace Modules\HR\Events\Recruitment;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Job;

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
