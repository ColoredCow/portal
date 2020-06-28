<?php

namespace Modules\HR\Events;

use App\Models\HR\ApplicationRound;
use Illuminate\Queue\SerializesModels;

class ApplicationMovedToNewRound
{
    use SerializesModels;

    public $applicationRound;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ApplicationRound $applicationRound)
    {
        $this->applicationRound = $applicationRound;
    }
}
