<?php

namespace Modules\HR\Events;

use Illuminate\Queue\SerializesModels;
use Modules\HR\Entities\ApplicationRound;

class ApplicationMovedToNewRound
{
    use SerializesModels;

    public $applicationRound;
    public $application;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ApplicationRound $applicationRound, array $data)
    {
        $this->applicationRound = $applicationRound;
        $this->application = $applicationRound->application;
        $this->data = $data;
    }
}
