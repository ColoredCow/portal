<div class="timeline mb-5">
    @foreach ($timeline as $item)
        <div class="timeline-container mb-3">
            <div class="content">
                @switch($item['type'])
                    @case('application-created')
                        @php
                            $application = $item['application'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($application->created_at)) }}</u></b><br>
                        <div>Applied for {{ $application->job->title }}</div>
                        @if ($application->autoresponder_subject && $application->autoresponder_body)
                            <span data-toggle="modal" data-target="#autoresponder_mail" class="badge badge-success text-white p-1 modal-toggler-text text-primary c-pointer fz-12">View mail</span>
                            @include('hr.application.auto-respond', ['applicant' => $application->applicant, 'application' => $application])
                        @endif
                        @if ($currentApplication->id != $application->id)
                            <a href="{{ route('applications.job.edit', $application) }}" class="fz-14 d-block">
                                <span>Go to application</span>
                                <span><i class="fa fa-external-link" aria-hidden="true"></i></span>
                            </a>
                        @endif
                        @break
                    @case('round-conducted')
                        @php
                            $applicationRound = $item['applicationRound'];
                            $application = $item['application'];
                        @endphp
                        <b><u>{{ $applicationRound->conducted_date->format(config('constants.display_date_format')) }}</u></b><br>
                        {{ $applicationRound->round->isTrialRound()? $applicationRound->trialRound->name : $applicationRound->round->name }} for {{ $application->job->title }} conducted by {{ $applicationRound->conductedPerson->name }}<br>
                        @if ($applicationRound->mail_sent)
                            <span data-toggle="modal" data-target="#{{ $applicationRound->communicationMail['modal-id'] }}" class="{{ config("constants.hr.status.$applicationRound->round_status.class") }} modal-toggler">Communication mail</span><br>
                            @include('hr.communication-mail-modal', [ 'data' => $applicationRound->communicationMail ])
                        @endif
                        @break
                    @case(config('constants.hr.application-meta.keys.change-job'))
                        @php
                            $event = $item['event'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>
                        Moved from {{ $event->value->previous_job }} to {{ $event->value->new_job }}<br>
                        <span data-toggle="modal" data-target="#{{ $event->communicationMail['modal-id'] }}" class="{{ config("constants.hr.status.rejected.class") }} modal-toggler">Communication mail</span><br>
                        @include('hr.communication-mail-modal', ['data' => $event->communicationMail])
                        @break
                    @case(config('constants.hr.status.no-show.label'))
                        @php
                            $event = $item['event'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>
                        No show: {{ $event->value->round }}<br>
                        @if (isset($event->communicationMail['mail-subject']) && !is_null($event->communicationMail['mail-subject']) )
                            <span data-toggle="modal" data-target="#{{ $event->communicationMail['modal-id'] }}" class="{{ config("constants.hr.status.rejected.class") }} modal-toggler">Communication mail</span><br>
                            @include('hr.communication-mail-modal', ['data' => $event->communicationMail])
                        @endif
                        @break

                    @case(config('constants.hr.application-meta.keys.sent-for-approval'))
                        @php
                            $event = $item['event'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>
                        {{ $event->value->conductedPerson }} requested approval from {{ $event->value->supervisor }}
                        @break
                    @case(config('constants.hr.application-meta.keys.approved'))
                        @php $event = $item['event']; @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>
                        {{ $event->value->approvedBy }} approved this application
                        @break
                    @case(config('constants.hr.application-meta.keys.onboarded'))
                        @php
                            $event = $item['event'];
                        @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>
                        {{ $event->value->onboardedBy }} onboarded the applicant
                        @break

                    @case(config('constants.hr.application-meta.keys.custom-mail'))
                        @php $event = $item['event']; @endphp
                        <b><u>{{ date(config('constants.display_date_format'), strtotime($item['date'])) }}</u></b><br>{{ $item['title'] }}<br>
                        <span data-toggle="modal" data-target="#{{ $item['mail_data']['modal-id'] }}"
                            class="{{ config("constants.hr.status.custom-mail.class") }} modal-toggler c-pointer fz-12">View mail</span><br>
                        @include('hr.communication-mail-modal', ['data' => $item['mail_data']])
                    @break
                @endswitch
            </div>
        </div>
    @endforeach
    @if(!empty($followUpEntries))
        @foreach($followUpEntries as $followUp)
            <div>
                <b><u>{{ date(config('constants.display_date_format'), strtotime($followUp->created_at)) }}</u></b><br>
                <span>Followed up by
                    <img src="{{ $followUp->conductedBy->avatar }}"
                    class="w-20 h-20 rounded-circle mr-0.5" data-toggle="tooltip"
                    title="{{ $followUp->conductedBy->name }}">
                </span><br>
                <span data-toggle="modal" data-target="#followUp{{ $followUp->id }}" class="badge badge-success text-white p-1 modal-toggler-text text-primary c-pointer fz-12">View mail</span><br></br>
                @include('hr::follow-up.modal')
            </div>
        @endforeach
    @endif
</div>
