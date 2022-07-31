@extends('layouts.app')

@section('content')
<div class="container pb-8">
    <br>
    @php
        $menu = 'hr.menu';
        $formAction = route('recruitment.opportunities.store');
        // if ($job->type == 'volunteer') {
            // $menu = 'hr.volunteers.menu';
            // $formAction = route('volunteer.opportunities.store', $job->id);
            // }
    @endphp
    @include($menu)
    <br><br>
    <div class="d-none alert alert-success " id="successMessage" role="alert">
        <strong>Updated!</strong> Submitted successfully.
        <button type="button" class="close" id="closeSuccessMessage" aria-label="Close">
        </button>
    </div>
    <div class="d-flex justify-content-between">
        <div>
            <h2 class="mb-3">New Opportunity</h2>
        </div>
        <div>                                                   
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#domainformModal"> Add domain</button>
        </div>
    </div>
    <div class="modal fade" id="domainformModal" tabindex="-1" role="dialog" aria-labelledby="domainformModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="domainformModalLabel">Domain Name </h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="domain modal-body">
                    <form action="{{ route('hr-job-domains.storeJobdomain')}}" method="POST" id="domainForm" >
                        @csrf
                        <div class="form-group">
                            <label for="domainfield">name</label><strong class="text-danger">*</strong></label>
                            <input type="text" name="name" class="form-control"  id="name" aria-describedby="Help" placeholder="name"> 
                            <div class="d-none text-danger" name="error" id="domainerror"></div>
                        </div>        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addDomain">Save changes</button>  
                    </form>
                </div>
            </div>
        </div>
    </div>      
    <form action="{{ $formAction }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Details</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter job title..." value="{{ old('title') }}" autofocus required>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Status</label>
                        <select class="form-control" name="status" id="status" value="{{ old('status') }}">
                            @foreach (config('hr.opportunities-status') as $status => $label)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="title" class="fz-14 leading-none text-secondary mb-1">Type</label>
                        <select class="form-control" name="type" id="type" value="{{ old('type') }}">
                            <option value="job" {{ old('type') == 'job' ? 'selected' : '' }}>Job</option>
                            <option value="internship" {{ old('type') == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="domain" class="fz-14 leading-none text-secondary mb-1">Domain<strong class="text-danger">*</strong></label>
                        <select class="form-control" name="domain" id="domain "> 
                            @foreach ($domains as $domain)
                                <option value="{{ $domain->slug }}" {{ old('domain') == $domain ? 'selected' : '' }}>{{ $domain->domain }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="start_date" class="fz-14 leading-none text-secondary mb-1">Start Date</label>
                        <input type="date" class="form-control" id="job_start_date" name="start_date" value="{{ old('start_date') }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="end_date" class="fz-14 leading-none text-secondary mb-1">End Date</label>
                        <input type="date" class="form-control" id="job_end_date" name="end_date" value="{{ old('end_date') }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="fz-14 leading-none text-secondary mb-1">Description<strong class="text-danger">*</strong></label>
                    <textarea id="description" class="form-control richeditor" name="description" rows="4" placeholder="Enter job description...">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Interviewers</h5>
            </div>
            <div class="card-body">
                <div class="form-row">
                    @foreach ($rounds as $key => $round)
                        <div class="form-group col-md-5 {{ $key%2 ? 'offset-md-1' : '' }}">
                            <label for="round_{{ $round->id }}" class="fz-14 leading-none text-secondary mb-1">{{ $round->name }}</label>
                            <select
                                class="form-control"
                                name="rounds[{{ $round->id }}][hr_round_interviewer_id]"
                                id="round_{{ $round->id }}"
                                value="{{ old("rounds[$round->id][hr_round_interviewer_id]") }}">
                                <option value="">Select interviewer </option>
                                @foreach($interviewers as $interviewer )
                                    @php
                                        $selected = old("rounds[$round->id][hr_round_interviewer_id]") == $interviewer->id ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $interviewer->id }}" {{ $selected }}>{{ $interviewer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
