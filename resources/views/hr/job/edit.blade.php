@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>{{ $job->title }}</h1>
    <br>
    <a class="btn btn-info" href="/hr/jobs">See all jobs</a>
    <br><br>
    <div class="card">
        <form action="/hr/jobs/{{$job->id}}" method="POST">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="card-header">
                <span>Job Details</span>
                <span class="float-right">Created by - {{ $job->posted_by }}</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="facebook_post">Facebook post&nbsp;&nbsp;<i class="fa fa-facebook fa-lg"></i></label>
                        <input type="text" class="form-control" name="facebook_post" id="facebook_post" placeholder="Facebook link" value="{{ $job->facebook_post }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="twitter_post">Twitter post&nbsp;&nbsp;<i class="fa fa-twitter fa-lg"></i></label>
                        <input type="text" class="form-control" name="twitter_post" id="twitter_post" placeholder="Twitter link" value="{{ $job->twitter_post }}">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="linkedin_post">LinkedIn post&nbsp;&nbsp;<i class="fa fa-linkedin fa-lg"></i></label>
                        <input type="text" class="form-control" name="linkedin_post" id="linkedin_post" placeholder="LinkedIn link" value="{{ $job->linkedin_post }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="instagram_post">Instagram post&nbsp;&nbsp;<i class="fa fa-instagram fa-lg"></i></label>
                        <input type="text" class="form-control" name="instagram_post" id="instagram_post" placeholder="Instagram link" value="{{ $job->instagram_post }}">
                    </div>
                </div>
                <br>
                @if (sizeof($rounds))
                    <h3>Interviewers</h3>
                    <div class="form-row">
                    @foreach ($rounds as $key => $round)
                        <div class="form-group col-md-5 {{ $key%2 ? 'offset-md-1' : '' }}">
                            <label for="rounds[{{ $round->id }}][hr_round_interviewer]">{{ $round->name }}</label>
                            @php
                                $round_interviewer = '';
                            @endphp
                            @foreach ($job->rounds as $job_round)
                                @if ($job_round->pivot->hr_round_id === $round->id )
                                    @php
                                        $round_interviewer = $job_round->pivot->hr_round_interviewer;
                                    @endphp
                                    @break
                                @endif
                            @endforeach
                            <input type="text" class="form-control" name="rounds[{{ $round->id }}][hr_round_interviewer]" id="round_{{ $round->id }}" placeholder="{{ $round->name }}" value="{{ $round_interviewer }}">
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
