<?php

namespace Modules\HR\Events;

use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\Application;

class CustomMailTriggeredForApplication
{
    use SerializesModels;

    public $application;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Application $application, array $data)
    {
        $this->application = $application;
        $this->data = $data;
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
