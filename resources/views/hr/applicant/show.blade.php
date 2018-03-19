@extends('layouts.app')

@section('content')
<div class="container">
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
                    <div class="card">
                        <div class="card-header">
                            <span>{{ $round->name }}</span>
                            {{-- <span class="float-right">Interviewer -  </span> --}}
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="">Feedback</label>
                                    <textarea name="feedbackround[{{ $round->id }}]" id="" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success">Move to next round</button>
                            <button class="btn btn-danger">Reject</button>
                            <h6 class="text-success d-none"><i class="fa fa-check"></i>Accepted in this round</h6>
                            <h6 class="text-danger d-none"><i class="fa fa-close"></i>Rejected</h6>
                        </div>
                    </div>
                    @break
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
