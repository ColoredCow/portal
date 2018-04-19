@extends('layouts.app')

@section('content')

<div class="container" id="page_hr_applicant_edit">
    <div class="row">
        <div class="col-md-12">
            <br>
            @include('hr.menu', ['active' => 'applicants'])
            <br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('status', ['errors' => $errors->all()])
        </div>
        <div class="col-md-3">
            @include('hr.applicant.timeline', ['applicant' => $applicant])
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline float-left">Applicant Details</div>
                    <div class="{{ config("constants.hr.status.$applicant->status.class") }} text-uppercase float-right card-status-highlight">{{ config("constants.hr.status.$applicant->status.title") }}</div>
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
            @foreach ($applicant->applicantRounds->reverse() as $applicantRound)
                @php
                    $applicantReview = $applicantRound->applicantReviews->where('review_key', 'feedback')->first();
                    $applicantReviewValue = $applicantReview ? $applicantReview->review_value : '';
                @endphp
                <br>
                <applicant-round-form-component
                :applicant-round="{{ json_encode($applicantRound) }}"
                :unconducted-applicant-rounds="{{ json_encode($unconductedApplicantRounds) }}"
                :applicant-review-value="{{ json_encode($applicantReviewValue) }}"
                :csrf-token="{{ json_encode(csrf_token()) }}"
                :is-active="{{ json_encode($loop->first) }}">
                </applicant-round-form-component>

                @include('hr.round-guide-modal', ['round' => $applicantRound->round])
                @if ($applicantRound->round_status)
                    @if ($applicantRound->mail_sent)
                        @include('hr.round-review-sent-mail-modal', [ 'applicantRound' => $applicantRound ])
                    @else
                        @include('hr.round-review-mail-modal', [ 'applicantRound' => $applicantRound ])
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
