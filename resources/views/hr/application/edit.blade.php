@extends('layouts.app')

@section('content')

<div class="container" id="page_hr_applicant_edit">
    <div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.menu')
            <br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
        </div>
        <div class="col-md-3">
            @include('hr.application.timeline', ['timeline' => $timeline])
        </div>
        <div class="col-md-7" v-bind:class="{ 'offset-md-2': showResumeFrame }">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline float-left">Applicant Details</div>
                    <div class="{{ config("constants.hr.status.$application->status.class") }} text-uppercase float-right card-status-highlight">{{ config("constants.hr.status.$application->status.title") }}</div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <b>Name</b>
                            <div>
                                {{ $applicant->name }}
                                @if ($applicant->linkedin)
                                    <a href="{{ $applicant->linkedin }}" target="_blank"><i class="fa fa-linkedin-square pl-1 fa-lg"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Applied for</b>
                            <div><a href="{{ $application->job->link }}" target="_blank">{{ $application->job->title }}</a></div>
                        </div>
                        <div class="form-group col-md-5">
                            <b>Phone</b>
                            <div>{{ $applicant->phone ?? '-' }}</div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Email</b>
                            <div>{{ $applicant->email }}</div>
                        </div>
                        <div class="form-group col-md-5">
                            <b>College</b>
                            <div>{{ $applicant->college ?? '-' }}</div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Course</b>
                            <div>{{ $applicant->course ?? '-' }}</div>
                        </div>
                        <div class="form-group col-md-5">
                            <b>Resume</b>
                            <div>
                            @if ($application->resume)
                                @include('hr.application.inline-resume', ['resume' => $application->resume])
                            @else
                                –
                            @endif
                            </div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Graduation Year</b>

                            <div>
                                {{ $applicant->graduation_year ?? '-' }}&nbsp;
                                @includeWhen(isset($hasGraduated) && !$hasGraduated, 'hr.job-to-internship-modal', ['application' => $application])
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <b>Reason for eligibility</b>
                            <div>{{ $application->reason_for_eligibility ?? '-' }}</div>
                        </div>
                        @if (isset($applicationFormDetails->value))
                            @foreach(json_decode($applicationFormDetails->value) as $field => $value)
                                <div class="form-group col-md-12">
                                    <b>{{ $field }}</b>
                                    <div>{{ $value }}</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @foreach ($application->applicationRounds as $applicationRound)
                @php
                    $applicationRoundReview = $applicationRound->applicationRoundReviews->where('review_key', 'feedback')->first();
                    $applicationRoundReviewValue = $applicationRoundReview ? $applicationRoundReview->review_value : '';
                @endphp
                <br>
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                            <div>
                                {{ $applicationRound->round->name }}
                                <span title="{{ $applicationRound->round->name }} guide" class="modal-toggler-text text-muted" data-toggle="modal" data-target="#round_guide_{{ $applicationRound->round->id }}">
                                    <i class="fa fa-info-circle fa-lg"></i>
                                </span>
                            </div>
                            @if ($applicationRound->round_status)
                                <span>Conducted By: {{ $applicationRound->conductedPerson->name }}</span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column align-items-end">
                                @if ($applicationRound->noShow && $applicationRound->round->reminder_enabled)
                                    <span class="text-danger"><i class="fa fa-warning fa-lg"></i>&nbsp;{{ config('constants.hr.status.no-show-reminded.title') }}</span>
                                @endif

                                @if ($applicationRound->round_status === config('constants.hr.status.confirmed.label'))
                                    <div class="text-success"><i class="fa fa-check"></i>&nbsp;{{ config('constants.hr.status.confirmed.title') }}</div>
                                @elseif ($applicationRound->round_status == config('constants.hr.status.rejected.label'))
                                    <div class="text-danger"><i class="fa fa-close"></i>&nbsp;{{ config('constants.hr.status.rejected.title') }}</div>
                                @endif
                                @if ($applicationRound->round_status && $applicationRound->conducted_date)
                                    <span>Conducted on: {{ date(config('constants.display_date_format'), strtotime($applicationRound->conducted_date)) }}</span>
                                @endif
                            </div>
                            <div class="icon-pencil position-relative ml-3" data-toggle="collapse" data-target="#collapse_{{ $loop->iteration }}"><i class="fa fa-pencil"></i></div>
                        </div>
                    </div>

                    <form action="/hr/applications/rounds/{{ $applicationRound->id }}" method="POST" class="applicant-round-form">

                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <div id="collapse_{{ $loop->iteration }}" class="collapse {{ $loop->last ? 'show' : '' }}">
                            <div class="card-body">
                                @if (!$applicationRound->round_status)
                                <div class="form-row">
                                    <div class="form-group col-md-5">
                                        <label for="scheduled_date">Scheduled date</label>
                                        <input type="datetime-local" name="scheduled_date" id="scheduled_date" class="form-control form-control-sm" value="{{ date(config('constants.display_datetime_format'), strtotime($applicationRound->scheduled_date)) }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="scheduled_person_id">Scheduled for</label>
                                        <select name="scheduled_person_id" id="scheduled_person_id" class="form-control form-control-sm" >
                                            @foreach ($interviewers as $interviewer)
                                                @php
                                                    $selected = $applicationRound->scheduled_person_id == $interviewer->id ? 'selected="selected"' : '';
                                                @endphp
                                                <option value="{{ $interviewer->id }}" {{ $selected }}>{{ $interviewer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-info btn-sm round-submit update-schedule" data-action="schedule-update">Update Schedule</button>
                                    </div>
                                </div>
                                @endif
                                <div class="form-row">
                                     <div class="form-group col-md-12">
                                        <button class="btn btn-warning btn-sm text-white" @click="getApplicationEvaluation({{ $applicationRound->id }})">Application Evaluation</button>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        @php
                                            if ($loop->last && sizeOf($errors)) {
                                                $applicationRoundReviewValue = old('reviews.feedback');
                                            }
                                        @endphp
                                        <textarea name="reviews[feedback]" id="reviews[feedback]" rows="6" class="form-control">{{ $applicationRoundReviewValue }}</textarea>
                                    </div>
                                </div>
                                @if ($applicationRound->round_status)
                                    <div class="form-row d-flex justify-content-end">
                                        <button type="button" class="btn btn-info btn-sm round-submit" data-action="update">Update feedback</button>
                                    </div>
                                @endif
                            </div>
                            @if (!$applicationRound->mail_sent)
                            <div class="card-footer">
                                <div class="d-flex align-items-center">
                                @if ($applicationRound->showActions)
                                    <select name="action_type" id="action_type" class="form-control w-50" v-model="selectedAction" data-application-job-rounds="{{ json_encode($application->job->rounds) }}">
                                        <option v-for="round in applicationJobRounds" value="round" :data-next-round-id="round.id">Move to @{{ round.name }}</option>
                                        <option value="send-for-approval">Send for approval</option>
                                        <option value="approve">Approve</option>
                                    </select>
                                    <button type="button" class="btn btn-success ml-2" @click="takeAction()">Take action</button>
                                @endif
                                @if ($loop->last && !$application->isRejected())
                                    @if ($applicantOpenApplications->count() > 1)
                                        <button type="button" class="btn btn-outline-danger ml-2" data-toggle="modal" data-target="#application_reject_modal">Reject</button>
                                        @include('hr.application.rejection-modal', ['currentApplication' => $application, 'allApplications' => $applicantOpenApplications ])
                                    @else
                                        <button type="button" class="btn btn-outline-danger ml-2 round-submit" data-action="reject">Reject</button>
                                    @endif
                                @endif
                                @if (!is_null($applicationRound->round_status) && !$applicationRound->mail_sent)
                                    <button type="button" class="btn btn-primary ml-auto" data-toggle="modal" data-target="#round_{{ $applicationRound->id }}">Send mail</button>
                                @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        <input type="hidden" name="action" value="updated">
                        <input type="hidden" name="next_round" value="">
                        @includeWhen($applicationRound->round_status != config('constants.hr.status.confirmed.label'), 'hr.round-review-confirm-modal', ['applicationRound' => $applicationRound])
                        @includeWhen($loop->last, 'hr.application.send-for-approval-modal')
                        @includeWhen($loop->last, 'hr.application.onboard-applicant-modal')
                    </form>
                </div>
                @include('hr.round-guide-modal', ['round' => $applicationRound->round])
                @includeWhen($applicationRound->round_status && !$applicationRound->mail_sent, 'hr.round-review-mail-modal', ['applicantRound' => $applicationRound])
            @endforeach
            @include('hr.application.application-evaluation')
        </div>
    </div>
</div>
@endsection
