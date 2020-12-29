@extends('layouts.app')

@section('content')
<div class="container pb-8">
    <br>
    @php
        $menu = 'hr.menu';
        $formAction = route('recruitment.opportunities.update', $job->id);
        if ($job->type == 'volunteer') {
            $menu = 'hr.volunteers.menu';
            $formAction = route('volunteer.opportunities.update', $job->id);
        }
    @endphp
    @include($menu)
    <br><br>
    @include('status', ['errors' => $errors->all()])
    <h2 class="mb-3">{{ $job->title }}</h2>
    <form action="{{ $formAction }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Details</h5>
                <span class="float-right">
                    <span class="fz-14 leading-none text-secondary">Created by {{ $job->posted_by }}</span>
                </span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="description" class="fz-14 leading-none text-secondary mb-0.16">Job Description</label>
                    <textarea id="description" class="form-control" name="description" rows="4" placeholder="Enter job description...">{{$job->description}}</textarea>
                </div>
            </div>
        </div>
        @if (sizeof($job->rounds))
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Interviewers</h5>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        @foreach ($job->rounds as $key => $round)
                            <div class="form-group col-md-5 {{ $key%2 ? 'offset-md-1' : '' }}">
                                <label for="round_{{ $round->id }}" class="fz-14 leading-none text-secondary mb-0.16">{{ $round->name }}</label>
                                    <select
                                        class="form-control"
                                        name="rounds[{{ $round->id }}][hr_round_interviewer_id]"
                                        id="round_{{ $round->id }}"
                                        value="{{ $round->pivot->hr_round_interviewer_id }}">
                                        <option value="">Select interviewer </option>
                                        @foreach($interviewers as $interviewer )
                                            @php
                                                $selected = $round->pivot->hr_round_interviewer_id == $interviewer->id ? 'selected="selected"' : '';
                                            @endphp
                                            <option value="{{ $interviewer->id }}" {{ $selected }}>{{ $interviewer->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Social Media Links</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="facebook_post" class="fz-14 leading-none text-secondary mb-0.16">Facebook post&nbsp;&nbsp;<i class="fa fa-facebook"></i></label>
                        <input type="text" class="form-control" name="facebook_post" id="facebook_post" placeholder="Facebook link" value="{{ $job->facebook_post }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="twitter_post" class="fz-14 leading-none text-secondary mb-0.16">Twitter post&nbsp;&nbsp;<i class="fa fa-twitter"></i></label>
                        <input type="text" class="form-control" name="twitter_post" id="twitter_post" placeholder="Twitter link" value="{{ $job->twitter_post }}">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="linkedin_post" class="fz-14 leading-none text-secondary mb-0.16">LinkedIn post&nbsp;&nbsp;<i class="fa fa-linkedin"></i></label>
                        <input type="text" class="form-control" name="linkedin_post" id="linkedin_post" placeholder="LinkedIn link" value="{{ $job->linkedin_post }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="instagram_post" class="fz-14 leading-none text-secondary mb-0.16">Instagram post&nbsp;&nbsp;<i class="fa fa-instagram"></i></label>
                        <input type="text" class="form-control" name="instagram_post" id="instagram_post" placeholder="Instagram link" value="{{ $job->instagram_post }}">
                    </div>
                </div>
            </div>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ $job->link }}" target="_blank" class="btn btn-info" role="button">Preview job</a>
        </div>
    </form>
</div>
@endsection
