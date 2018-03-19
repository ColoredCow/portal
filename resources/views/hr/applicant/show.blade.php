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
                    </div>
                    <div class="form-row">
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
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <span>Round 1 - Telephonic interview</span>
                    <span class="float-right">Interviewer - Vaibhav Rathore</span>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <b>Field 1</b>
                            <div></div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Field 2</b>
                            <div></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <b>Field 3</b>
                            <div></div>
                        </div>
                        <div class="form-group offset-md-1 col-md-5">
                            <b>Field 4</b>
                            <div></div>
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
        </div>
    </div>
</div>
@endsection
