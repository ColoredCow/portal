@extends('layouts.app')

@section('content')

<div class="container" id="page-hr-applicant-edit">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
            @if ($rounds)
                @foreach ($rounds as $round)
                    <br>
                    <form action="/hr/applicants/{{$applicant->id}}" method="POST" class="applicant-round-form">

                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <div class="card">
                            <div class="card-header">
                                <span>{{ $round->name }}</span>
                                {{-- <span class="float-right">Interviewer -  </span> --}}
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="">Feedback</label>
                                        @php
                                            $feedback = '';
                                        @endphp
                                        @foreach ($applicant_rounds as $applicant_round)
                                            @foreach ($applicant_round->applicantReviews as $applicant_review)
                                                @if ($applicant_review->review_key == 'feedback')
                                                    @php
                                                    $feedback = $applicant_review->review_value;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <textarea name="reviews[feedback]" id="review[feedback]" rows="10" class="form-control">{{ $feedback }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                @foreach ($applicant_rounds as $applicant_round)
                                    @if (! $applicant_round->round_status)
                                        <button type="button" class="btn btn-success round-submit" data-status="confirmed">Move to next round</button>
                                        <button type="button" class="btn btn-danger round-submit" data-status="rejected">Reject</button>
                                    @endif
                                    @foreach ($applicant_round->applicantReviews as $applicant_review)
                                        @if ($applicant_review->review_key == 'feedback')
                                            @if ($applicant_round->round_status == 'confirmed')
                                                <h6 class="text-success"><i class="fa fa-check"></i>Accepted in this round</h6>
                                            @elseif ($applicant_round->round_status == 'rejected')
                                                <h6 class="text-danger"><i class="fa fa-close"></i>Rejected</h6>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="round_status" value="">
                        <input type="hidden" name="round_id" value="{{ $round->id }}">
                    </form>
                    @break
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
