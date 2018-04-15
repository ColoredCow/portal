@extends('layouts.app')

@section('content')

<div class="container" id="page_hr_applicant_edit">
    <div class="row">
        <div class="col-md-12">
            <br>
            <a class="btn btn-info" href="/hr/applicants">See all applicants</a>
            <br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
            <br>
        </div>
        <div class="col-md-3">
            @include('hr.applicant.timeline', ['applicant' => $applicant])
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline float-left">Applicant Details</div>
                    @switch ($applicant->status)
                        @case('new')
                        @default
                            <div class="badge badge-info text-uppercase float-right card-status-highlight">
                            @break
                        @case('rejected')
                            <div class="badge badge-danger text-uppercase float-right card-status-highlight">
                            @break
                        @case('in-progress')
                            <div class="badge badge-warning text-uppercase float-right card-status-highlight">
                            @break
                    @endswitch
                    {{ $applicant->status }}</div>
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
                            <div><a href="{{ $applicant->job->link }}" target="_blank">{{ $applicant->job->title }}</a></div>
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
                            @if ($applicant->resume)
                                <a href="{{ $applicant->resume }}" target="_blank"><i class="fa fa-file fa-2x"></i></a>
                            @else
                                –
                            @endif
                            </div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Graduation Year</b>
                            <div>{{ $applicant->graduation_year ?? '-' }}</div>
                        </div>
                        <div class="form-group col-md-12">
                            <b>Reason for eligibility</b>
                            <div>{{ $applicant->reason_for_eligibility ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($applicant->applicantRounds as $applicantRound)
                @php
                    $applicantReview = $applicantRound->applicantReviews->where('review_key', 'feedback')->first();
                    $applicantReviewValue = $applicantReview ? $applicantReview->review_value : '';
                @endphp
                <br>
                <form action="/hr/applicants/rounds/{{ $applicantRound->id }}" method="POST" class="applicant-round-form">

                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="card">
                        <div class="card-header">
                            <div class="d-inline float-left">
                                {{ $applicantRound->round->name }}
                                <span title="{{ $applicantRound->round->name }} guide" class="modal-toggler-text text-muted" data-toggle="modal" data-target="#round_guide_{{ $applicantRound->round->id }}">
                                    <i class="fa fa-info-circle fa-lg"></i>
                                </span>
                            </div>
                            <div class="d-inline float-right">
                                @if ($applicantRound->round_status == 'confirmed')
                                    <div class="text-success"><i class="fa fa-check"></i>Accepted in this round</div>
                                @elseif ($applicantRound->round_status == 'rejected')
                                    <div class="text-danger"><i class="fa fa-close"></i>Rejected</div>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="reviews[feedback]">Feedback</label>
                                    <textarea name="reviews[feedback]" id="reviews[feedback]" rows="10" class="form-control">{{ $applicantReviewValue }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        @if (! $applicantRound->round_status)
                            <applicant-round-action-component></applicant-round-action-component>
                            <button type="button" class="btn btn-success round-submit" data-status="confirmed">Move to next round</button>
                            <button type="button" class="btn btn-danger round-submit" data-status="rejected">Reject</button>
                        @else
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    @if ($applicantRound->round_status == 'confirmed')
                                        <button type="button" class="btn btn-info round-submit" data-status="confirmed">Update</button>
                                        <button type="button" class="btn btn-outline-danger round-submit" data-status="rejected">Reject</button>
                                    @elseif ($applicantRound->round_status == 'rejected')
                                        <button type="button" class="btn btn-info round-submit" data-status="rejected">Update</button>
                                        <applicant-round-action-component
                                        :rounds="{{ json_encode($job->rounds) }}">
                                        </applicant-round-action-component>
                                    @endif
                                </div>
                                <div>
                                    @if ($applicantRound->mail_sent)
                                        <span class="modal-toggler-text text-primary" data-toggle="modal" data-target="#round_mail_{{ $applicantRound->id }}">Mail sent for this round</span>
                                    @else
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#round_{{ $applicantRound->id }}">Send mail</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                        </div>
                    </div>
                    <input type="hidden" name="round_status" value="">
                </form>
                @include('hr.round-guide-modal', ['round' => $applicantRound->round])
                @if ($applicantRound->round_status)
                    @if ($applicantRound->mail_sent)
                        @include('hr.round-review-sent-mail-modal', [ 'applicantRound' => $applicantRound ])
                    @else
                        @include('hr.round-review-mail-modal', [ 'applicantRound' => $applicantRound ])
                    @endif
                @endif
                @break
            @endforeach
        </div>
    </div>
</div>
@endsection
