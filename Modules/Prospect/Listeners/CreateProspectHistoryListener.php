<?php

namespace Modules\Prospect\Listeners;

use Modules\Prospect\Entities\ProspectHistory;

class CreateProspectHistoryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle($event)
    {
        $data = $event->data;
        $data['created_by'] = \Auth::id() ?: null;
        $prospect = $event->prospect;
        $prospect->histories()->save(new ProspectHistory($data));
    }
}
