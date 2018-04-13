<div class="timeline mb-5">
    <div class="timeline-container">
        <div class="content">
            <b>{{ date(config('constants.display_date_format'), strtotime($applicant->created_at)) }}</b><br>
            Applied for {{ $applicant->job->title }}
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
                    <b>{{ date(config('constants.display_date_format'), strtotime($applicantRound->conducted_date)) }}</b><br>
                    {{ $applicantRound->round->name }} conducted by {{ $applicantRound->conductedPerson->name }}
                </div>
            </div>
        @endif
        @if ($applicantRound->mail_sent)
            <div class="timeline-container">
                <div class="content">
                    <b>{{ date(config('constants.display_date_format'), strtotime($applicantRound->mail_sent_at)) }}</b><br>
                    <span data-toggle="modal" data-target="#round_mail_{{ $applicantRound->id }}" class="modal-toggler-text text-primary">Communication mail for {{ $applicantRound->round->name }}</span>
                </div>
            </div>
        @endif
    @endforeach
</div>
