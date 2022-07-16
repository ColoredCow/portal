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
    <h2 class="mb-3">Edit Opportunity</h2>
    <form action="{{ $formAction }}" method="POST" id="update-form">
        @csrf
        @method('PATCH')
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Details</h5>
                @if ($job->postedBy)
                    <div class="float-right fz-14 leading-none text-secondary d-flex align-items-center">
                        <span class="mr-1">Posted by</span>
                        <img src="{{ $job->postedBy->avatar }}" alt="{{ $job->postedBy->name }}" class="rounded-circle w-20 h-20" data-toggle="tooltip" title="{{ $job->postedBy->name }}">
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Job Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter job title..." value="{{ old('title', $job->title) }}" autofocus required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Status</label>
                        <select class="form-control" name="status" id="status" value="{{ old('status') }}">
                            @foreach (config('hr.opportunities-status') as $status => $label)
                                <option value="{{ $status }}" {{ old('status', $job->status) == $status ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Type</label>
                        <select class="form-control" name="type" id="type" value="{{ old('type') }}">
                            <option value="job" {{ old('type', $job->type) == 'job' ? 'selected' : '' }}>Job</option>
                            <option value="internship" {{ old('type', $job->type) == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="domain" class="fz-14 leading-none text-secondary mb-1">Domain<strong class="text-danger">*</strong></label>
                        <select class="form-control" name="domain" id="domain " value="{{ old('type') }}"> 
                            @foreach($domains as $domain)
                                <option  value="{{ $domain->slug }}"  {{ old('domain') == $domain ? 'selected' : '' }}>{{ $domain->domain_name }}</option>
                            @endforeach 
                        </select>   
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="start_date" class="fz-14 leading-none text-secondary mb-1">Start Date</label>
                        <input type="date" class="form-control" id="job_start_date" name="start_date" max="{{ old('end_date', $job->end_date) }}" value="{{ old('start_date', $job->start_date) }}">     
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="end_date" class="fz-14 leading-none text-secondary mb-1">End Date</label>
                        <input type="date" class="form-control" id="job_end_date" name="end_date" min="{{ old('start_date', $job->start_date) }}" value="{{ old('end_date', $job->end_date) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="fz-14 leading-none text-secondary mb-1">Job Description<strong class="text-danger">*</strong></label>
                    <textarea id="description" class="form-control richeditor" name="description" rows="4" placeholder="Enter job description...">{{ old('description', $job->description) }}</textarea>
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
                                <label for="round_{{ $round->id }}" class="fz-14 leading-none text-secondary mb-1">{{ $round->name }}</label>
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
                        <label for="facebook_post" class="fz-14 leading-none text-secondary mb-1">Facebook post&nbsp;&nbsp;<i class="fa fa-facebook"></i></label>
                        <input type="text" class="form-control" name="facebook_post" id="facebook_post" placeholder="Facebook link" value="{{ $job->facebook_post }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="twitter_post" class="fz-14 leading-none text-secondary mb-1">Twitter post&nbsp;&nbsp;<i class="fa fa-twitter"></i></label>
                        <input type="text" class="form-control" name="twitter_post" id="twitter_post" placeholder="Twitter link" value="{{ $job->twitter_post }}">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="linkedin_post" class="fz-14 leading-none text-secondary mb-1">LinkedIn post&nbsp;&nbsp;<i class="fa fa-linkedin"></i></label>
                        <input type="text" class="form-control" name="linkedin_post" id="linkedin_post" placeholder="LinkedIn link" value="{{ $job->linkedin_post }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="instagram_post" class="fz-14 leading-none text-secondary mb-1">Instagram post&nbsp;&nbsp;<i class="fa fa-instagram"></i></label>
                        <input type="text" class="form-control" name="instagram_post" id="instagram_post" placeholder="Instagram link" value="{{ $job->instagram_post }}">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary  ml-2" form="update-form">Update</button>
        <a href="{{ $job->link }}" target="_blank" class="btn btn-info  ml-2" role="button">Preview job</a>
        <form action="{{ route('recruitment.opportunities.destroy', $job) }}" method="POST" id="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger  ml-2" onclick="return confirm('Are you sure you want to delete?')" form="delete-form">Delete</button>
        </form>
    </div>
</div>
@endsection
