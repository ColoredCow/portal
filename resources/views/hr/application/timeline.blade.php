<div class="timeline mb-5">
    @foreach ($timeline as $item)
        <div class="timeline-container">
            <div class="content">
                @switch($item['type'])
                    @case('application-created')
                        @php
                            $application = $item['application'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($application->created_at)) }}</u></b><br>
                        <div>Applied for {{ $application->job->title }}</div>
                        @if ($application->autoresponder_subject && $application->autoresponder_body)
                            <span data-toggle="modal" data-target="#autoresponder_mail" class="modal-toggler-text text-primary">Auto-respond mail from system</span>
                            @include('hr.application.auto-respond', ['applicant' => $application->applicant, 'application' => $application])
                        @endif
                        @break
                    @case('round-conducted')
                        @php
                            $applicationRound = $item['applicationRound'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($applicationRound->conducted_date)) }}</u></b><br>
                        {{ $applicationRound->round->name }} for {{ $applicationRound->application->job->title }} conducted by {{ $applicationRound->conductedPerson->name }}<br>
                        @if ($applicationRound->mail_sent)
                            <span data-toggle="modal" data-target="#round_mail_{{ $applicationRound->id }}" class="{{ config("constants.hr.status.$applicationRound->round_status.class") }} modal-toggler">Communication mail</span><br>
                            @include('hr.round-review-sent-mail-modal', [ 'applicationRound' => $applicationRound ])
                        @endif
                        @break
                @endswitch
            </div>
        </div>
    @endforeach
</div>
