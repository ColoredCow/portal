<?php

namespace App\Listeners\HR;

use App\Events\HR\ApplicantUpdated;
use App\Models\HR\ApplicantReview;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UpdateApplicantRound
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
     * @param  ApplicantUpdated  $event
     * @return void
     */
    public function handle(ApplicantUpdated $event)
    {
        $applicant = $event->applicant;
        $attr = $event->attr;

        if ( ! array_key_exists('round_status', $attr)
            || ! array_key_exists('round_id', $attr)
            || ! array_key_exists('reviews', $attr)
        ) return;


        $applicant_round = $applicant->getApplicantRound($attr['round_id']);
        $applicant_round->_update([
            'conducted_person_id' => Auth::user()->id,
            'conducted_date' => Carbon::now(),
            'round_status' => $attr['round_status'],
        ]);

        $applicant_round->_updateOrCreateReviews($attr['reviews']);
    }
}
