<div class="timeline mb-5">
    <div class="timeline-container">
        <div class="content">
            <b><u>{{ date(config('constants.display_date_format'), strtotime($applicant->created_at)) }}</u></b><br>
            Applied for {{ $applicant->job->title }}
            <br>
            @if ($applicant->autoresponder_subject && $applicant->autoresponder_body)
                <span data-toggle="modal" data-target="#autoresponder_mail" class="modal-toggler-text text-primary">Auto-respond mail for system</span>
                @include('hr.applicant.auto-respond', ['applicant' => $applicant])
            @endif
        </div>
    </div>
    @foreach ($applicant->applicantRounds as $applicantRound)
        @if ($applicantRound->scheduled_date)
            <div class="timeline-container">
                <div class="content">
                    {{ $applicantRound->round->name }} scheduled on {{ date(config('constants.display_date_format'), strtotime($applicantRound->scheduled_date)) }}
                </div>
            </div>
        @endif
        @if ($applicantRound->conducted_date)
            <div class="timeline-container">
                <div class="content">
                    <b><u>{{ date(config('constants.display_date_format'), strtotime($applicantRound->conducted_date)) }}</u></b><br>
                    {{ $applicantRound->round->name }} conducted by {{ $applicantRound->conductedPerson->name }}<br>
                    @if ($applicantRound->mail_sent)
                        <span data-toggle="modal" data-target="#round_mail_{{ $applicantRound->id }}" class="{{ config("constants.hr.status.$applicantRound->round_status.class") }} modal-toggler">Communication mail</span><br>
                        @include('hr.round-review-sent-mail-modal', [ 'applicantRound' => $applicantRound ])
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>
