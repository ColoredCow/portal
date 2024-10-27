<?php
namespace Modules\HR\Events;

use Illuminate\Queue\SerializesModels;

class InterviewCommunicationEmailSent
{
    use SerializesModels;

    private $condition;
    private $options;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($condition, $options)
    {
        $this->setCondition($condition);
        $this->setOptions($options);
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

    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getOptions($key)
    {
        return $this->options[$key] ?? null;
    }
}
