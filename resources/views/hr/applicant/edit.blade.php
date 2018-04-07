@extends('layouts.app')

@section('content')

<div class="container" id="page-hr-applicant-edit">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br>
            <a class="btn btn-info" href="/hr/applicants">See all applicants</a>
            <br><br>
            @include('errors', ['errors' => $errors->all()])
            <br>
            <div class="card">
                <div class="card-header">Applicant Details</div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <b>Name</b>
                            <div>{{ $applicant->name }}</div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Applied for</b>
                            <div>{{ $applicant->job->title }}</div>
                        </div>
                        <div class="form-group col-md-5">
                            <b>Phone</b>
                            @if ($applicant->phone)
                                <div>{{ $applicant->phone }}</div>
                            @else
                                <div>-</div>
                            @endif
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Email</b>
                            <div>{{ $applicant->email }}</div>
                        </div>
                        <div class="form-group col-md-5">
                            <b>Resume</b>
                            @if ($applicant->resume)
                                <div><a href="{{ $applicant->resume }}" target="_blank"><i class="fa fa-file fa-2x"></i></a></div>
                            @else
                                <div>–</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if ($job->rounds)
                @foreach ($job->rounds as $round)
                    <br>
                    <form action="/hr/applicants/{{$applicant->id}}" method="POST" class="applicant-round-form">

                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <div class="card">
                            <div class="card-header">
                                <span>{{ $round->name }}</span>
                                <span class="float-right">Interviewer - {{ $round->pivot->hr_round_interviewer }} </span>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="">Feedback</label>
                                        @php
                                            $applicant_round = $applicant->applicantRounds->where('hr_round_id', $round->id)->first();
                                            $applicant_review = $applicant_round->applicantReviews->where('review_key', 'feedback')->first();
                                            $applicant_review_value = $applicant_review ? $applicant_review->review_value : '';
                                        @endphp
                                        <textarea name="reviews[feedback]" id="review[feedback]" rows="10" class="form-control">{{ $applicant_review_value }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                            @foreach ($applicant_rounds as $applicant_round)
                                @if (! $applicant_round->round_status)
                                    <button type="button" class="btn btn-success round-submit" data-status="confirmed">Move to next round</button>
                                    <button type="button" class="btn btn-danger round-submit" data-status="rejected">Reject</button>
                                @else
                                    <div class="d-flex align-items-center justify-content-between">
                                    @if ($applicant_round->round_status == 'confirmed')
                                        <h6 class="text-success"><i class="fa fa-check"></i>Accepted in this round</h6>
                                    @elseif ($applicant_round->round_status == 'rejected')
                                        <h6 class="text-danger"><i class="fa fa-close"></i>Rejected</h6>
                                    @endif
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#round_{{ $applicant_round->id }}">Send mail</button>
                                    </div>
                                @endif
                            @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="round_status" value="">
                        <input type="hidden" name="round_id" value="{{ $round->id }}">
                    </form>
                    @if ($applicant_round->round_status)
                        @include('hr.round-review-mail-modal', [ 'applicant_round' => $applicant_round ])
                    @endif
                    @break
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
