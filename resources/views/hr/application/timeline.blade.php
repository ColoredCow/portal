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
                            $application = $item['application'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($applicationRound->conducted_date)) }}</u></b><br>
                        {{ $applicationRound->round->name }} for {{ $application->job->title }} conducted by {{ $applicationRound->conductedPerson->name }}<br>
                        @if ($applicationRound->mail_sent)
                            <span data-toggle="modal" data-target="#round_mail_{{ $applicationRound->id }}" class="{{ config("constants.hr.status.$applicationRound->round_status.class") }} modal-toggler">Communication mail</span><br>
                            @php
                                $data = [
                                    'modal-id' => 'round_mail_' . $applicationRound->id,
                                    'mail-subject' => $applicationRound->mail_subject,
                                    'mail-body' => $applicationRound->mail_body,
                                    'mail-sender' => $applicationRound->mailSender->name,
                                    'mail-to' => $applicationRound->application->applicant->email,
                                    'mail-date' => $applicationRound->mail_sent_at,
                                ];
                            @endphp
                            @include('hr.communication-mail-modal', [ 'data' => $data ])
                        @endif
                        @break
                    @case('job-changed')
                        @php
                            $jobChangeEvent = $item['jobChangeEvent'];
                            $details = $jobChangeEvent->value;
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>
                        Moved from {{ $details->previous_job }} to {{ $details->new_job }}<br>
                        @php
                            $data = [
                                'modal-id' => 'job_change_' . $jobChangeEvent->id,
                                'mail-subject' => $details->job_change_mail_subject,
                                'mail-body' => $details->job_change_mail_body,
                                'mail-sender' => $details->user,
                                'mail-to' => $jobChangeEvent->application->applicant->email,
                                'mail-date' => $jobChangeEvent->created_at,
                            ];
                        @endphp
                        <span data-toggle="modal" data-target="#job_change_{{ $jobChangeEvent->id }}" class="{{ config("constants.hr.status.rejected.class") }} modal-toggler">Communication mail</span><br>
                        @include('hr.communication-mail-modal', ['data', $data])
                        @break
                @endswitch
            </div>
        </div>
    @endforeach
</div>
