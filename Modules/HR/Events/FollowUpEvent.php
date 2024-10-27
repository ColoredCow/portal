<?php

namespace Modules\HR\Events;

use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;

class FollowUpEvent
{
    use SerializesModels;

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
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
