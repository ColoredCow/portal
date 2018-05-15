<div class="timeline mb-5">
    <div class="timeline-container">
        <div class="content">
            <b><u>{{ date(config('constants.display_date_format'), strtotime($applicant->created_at)) }}</u></b><br>
            Applied for
            @foreach($applicant->applications as $application)
                <div>{{ $application->job->title }}</div>
            @endforeach
            @if ($application->autoresponder_subject && $application->autoresponder_body)
                <span data-toggle="modal" data-target="#autoresponder_mail" class="modal-toggler-text text-primary">Auto-respond mail for system</span>
                @include('hr.application.auto-respond', ['applicant' => $applicant, 'application' => $application])
            @endif
        </div>
    </div>
    @foreach ($application->applicationRounds as $applicationRound)
        @if ($applicationRound->scheduled_date)
            <div class="timeline-container">
                <div class="content">
                    {{ $applicationRound->round->name }} scheduled on {{ date(config('constants.display_date_format'), strtotime($applicationRound->scheduled_date)) }}
                </div>
            </div>
        @endif
        @if ($applicationRound->conducted_date)
            <div class="timeline-container">
                <div class="content">
                    <b><u>{{ date(config('constants.display_date_format'), strtotime($applicationRound->conducted_date)) }}</u></b><br>
                    {{ $applicationRound->round->name }} conducted by {{ $applicationRound->conductedPerson->name }}<br>
                    @if ($applicationRound->mail_sent)
                        <span data-toggle="modal" data-target="#round_mail_{{ $applicationRound->id }}" class="{{ config("constants.hr.status.$applicationRound->round_status.class") }} modal-toggler">Communication mail</span><br>
                        @include('hr.round-review-sent-mail-modal', [ 'applicationRound' => $applicationRound ])
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>
