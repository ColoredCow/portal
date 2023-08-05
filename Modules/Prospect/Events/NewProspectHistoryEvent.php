<?php

namespace Modules\Prospect\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Prospect\Entities\Prospect;

class NewProspectHistoryEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $prospect;
    public $data;

    public function __construct(Prospect $prospect, $data)
    {
        $this->prospect = $prospect;
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
