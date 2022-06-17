@extends('layouts.app')

@section('content')
<div class="container" id="vueContainer">
    <br>
    @include('hr.menu')
    <br>
    <form class="form" action="/{{ Request::path() }}">
        <div class="row">
            <div class="col-md-3">
                <h1>Applications</h1>
            </div>
            <div class="input-group mb-1 col-md-6" style="display: flex;">
                <div class="d-flex">
                    <div class="input-group mb-3 col-md-9">
                        <input type="text" class="form-control w-300" id="search" placeholder="Enter a keyword" aria-describedby="button-addon2"
                        name="search" value= @if(request()->has('search')){{request()->get('search')}}@endif>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary d-flex justify-content-center align-items-center" type="button" id="button-addon2" data-toggle="modal" data-target="#application-modal">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-2 align-self-center application-search">
                        <button class="btn btn-info ">Search</button>
                    </div>
                </div>
            </div>
            <div class="text-right ml-5 ml-md-0">
                <a href="{{ route('hr.applicant.create') }}" class="btn btn-primary text-white">Add new application</a>
            </div>
        </div>
        <div class="md-row d-md-flex flex-md-row-reverse ml-4 ml-md-3 mt-sm-2 mt-md-0">
            <div class="d-flex flex-row">
                <div class="d-flex mt-2 mt-md-0">
                    <div class="mr-2 form-group">
                        <label id="start-year">{!! __('Start Year') !!}</label><br>
                        <input id="start-year" class="fz-14 fz-lg-16 p-1 w-120 w-md-180 form-control rounded border-0" name="start-year" type=number min="1900" max="9999" step=1 placeholder="Graduation Year" value="{{ old('start-year', request()->get('start-year')) }}">
                    </div>
                    <div class="mr-2 form-group">
                        <label id="end-year">{!! __('End Year') !!}</label><br>
                        <input id="end-year" class="fz-14 fz-lg-16 p-1 w-120 w-md-180 form-control rounded border-0" name="end-year" type=number min="1900" max="9999" step=1 placeholder="Graduation Year" value="{{ old('end-year', request()->get('end-year')) }}">
                    </div>
                </div>
                <button class="btn h-40 mt-6 mt-md-4 mt-xl-5 w-md-50 mr-md-2 theme-shadow-dark border pt-1">
                    <i class="fa fa-search c-pointer fz-20" aria-hidden="true"></i>
                </button>
            </div>
            <div class="mr-2 mt-2 mt-md-0 form-group">
                <label id="job">{!! __('Jobs') !!}</label><br>
                <select class="fz-14 fz-lg-16 w-120 w-220 form-control rounded border-0" name="hr_job_id" id="job"
                    onchange="this.form.submit()">
                    <option value="" {{ request()->has('hr_job_id') ? '' : 'selected' }}>
                        {!! __('All Jobs') !!}
                    </option>
                    @foreach ($jobs as $job)
                    <option value="{{ $job->id }}" {{ request()->get('hr_job_id') == $job->id ? 'selected' : '' }}>
                        {{ $job->title }} </option>
                    @endforeach
                </select>
            </div>
            <div class="mr-2 mt-2 mt-md-0 form-group">
                <label id="university">{!! __('University') !!}</label><br>
                <select class="fz-14 fz-lg-16 w-120 w-220 form-control rounded border-0" name="hr_university_id" id="university"
                    onchange="this.form.submit()">
                    <option value="" {{ request()->has('hr_university_id') ? '' : 'selected' }}>
                        {!! __('All University') !!}
                    </option>
                    @foreach ($universities as $university)
                    <option value="{{ $university->id }}" {{ request()->get('hr_university_id') == $university->id ? 'selected' : '' }}>
                        {{ $university->name }} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    @include('hr.application.filter-modal')
    @if(request()->has('search') || request()->has('tags'))
        <div class="row mt-3 mb-2">
            <div class="col-6">
                <a class="text-muted c-pointer"
                    href="/{{ Request::path() }}{{request()->has('status')?'?status='.request('status'):''}}{{request()->has('round')?'&round='.request('round'):''}}">
                </a>
            </div>
        </div>
    @endif
    <br>
    @php
        $hr_job_id = request()->has('hr_job_id') ? '&hr_job_id=' . request('hr_job_id') : '';
        $search = request()->has('search') ? '&search=' . request('search') : '';
        $query_filters = $hr_job_id . $search
    @endphp
    <div class="menu_wrapper">
        <div class ="navbar"  id="navbar">
            <li id="list-styling">
                <a id="job-application-listings" class= "{{ $status === config('constants.hr.status.new.label') ? 'job-application-status' : ( isset($status) ? '' : 'job-application-status' ) }} btn"
                    href=/{{ Request::path() }}?status={{ config('constants.hr.status.new.label') }}{{$query_filters}} >
                    <sup class = "application-menu-options-title fz-18">
                        {{$newApplicationsCount + $inProgressApplicationsCount - $trialProgramCount}}
                    </sup>
                    <div>
                        <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/people.svg')) !!}</span>
                        <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.new.label') ? 'text-underline' : '' }}">Open&nbsp</h5>
                    </div>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class="{{ $status === config('constants.hr.status.in-progress.label') ? 'job-application-status text-underline' : '' }} btn" 
                href=/{{ Request::path() }}?status={{ config('constants.hr.status.in-progress.label') }}{{$query_filters}}&round=trial-program>
                    <sup class = "application-menu-options-title fz-18">
                        {{$trialProgramCount}}
                    </sup>
                    <div>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/code.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.in-progress.label') ? 'text-underline' : '' }}">Trial Program</h5>    
                    </div>
                </a>
            </li>
            <li id="list-styling">
                <a class="{{ $status === config('constants.hr.status.on-hold.label') ? 'job-application-status text-underline' : '' }} btn" 
                href=/{{Request::path() .'?status='. config('constants.hr.status.on-hold.label')}}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18">
                        {{$onHoldApplicationsCount}}
                    </sup>
                    <div>
                        <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/pause-circle.svg')) !!}</span>
                        <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.on-hold.label') ? 'text-underline' : '' }}">On Hold</h5>
                    </div>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class="{{ $status === config('constants.hr.status.no-show.label') ? 'job-application-status text-underline':'' }} btn"
                href= /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18">
                        {{$noShowApplicationsCount+$noShowRemindedApplicationsCount}}
                    </sup>
                    <div>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/exclamation-octagon-fill.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.no-show.label') ? 'text-underline':'' }}">No Show</h5>
                    </div>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class="{{ $status === config('constants.hr.status.sent-for-approval.label') ? 'job-application-status text-underline' : '' }} btn"
                href= /{{ Request::path() .'?status='. config('constants.hr.status.sent-for-approval.label')}}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18">
                        {{$sentForApprovalApplicationsCount}}
                    </sup>
                    <div>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/clipboard.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'text-underline' : '' }}">To Approve</h5>
                    </div>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class= "{{ $status === config('constants.hr.status.approved.label') ? 'job-application-status text-underline' : '' }} btn"
                href= /{{ Request::path() }}?status={{ config('constants.hr.status.approved.label') }}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18">
                        {{$approvedApplicationsCount}}
                    </sup>
                    <div>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/clipboard-check.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.approved.label') ? 'text-underline' : '' }}">Approved</h5>
                    </div>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class="{{ $status === config('constants.hr.status.onboarded.label') ? 'job-application-status text-underline' : '' }} btn"
                href= /{{ Request::path() }}?status={{ config('constants.hr.status.onboarded.label') }}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18" >
                        {{$onboardedApplicationsCount}}
                    </sup>
                    <div>
                    <span class="d-inline-block h-26 w-26"> {!! file_get_contents(public_path('icons/person-check.svg')) !!} </span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.onboarded.label') ? 'text-underline' : '' }}">On Boarded</h5>
                    </div>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class= "{{ $status === config('constants.hr.status.rejected.label') ? 'job-application-status text-underline':'' }} btn"
                href= /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18" >
                        {{$rejectedApplicationsCount}}    
                    </sup>
                    <div>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/x-circle.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.rejected.label') ? 'text-underline':'' }}">Closed</h5>
                    </div>
                </a>
            </li>
        </div>
    </div>
    @if( isset($openJobsCount, $openApplicationsCount) )
        <div class="alert alert-info mb-2 p-2">
            <span>There are <b>{{ $openJobsCount }}</b> open jobs and <b>{{ $newApplicationsCount }}</b> open
                applications</span>
        </div>
    @endif

    <table class="table table-striped table-bordered" id="applicants_table">
        <thead>
            <th>Name</th>
            <th>Details</th>
            <th>
                <span class="dropdown-toggle c-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="assigneeDropdown">Assignee</span>
                <div class="dropdown-menu" aria-labelledby="assigneeDropdown">
                    <span class="dropdown-item-text fz-12">Filter by assignee</span>
                    @foreach ($assignees as $assignee)
                    @php
                    $target = route(request()->route()->getName(), ['assignee' => [$assignee->id]]);
                    $class = in_array($assignee->id, request()->get('assignee') ?? []) ? 'visible' : 'invisible';
                    @endphp
                    <a class="dropdown-item" href="{{ $target }}">
                        <i class="fa fa-check fz-12 {{ $class }}"></i>
                        <img src="{{ $assignee->avatar }}" alt="{{ $assignee->name }}"
                            class="w-20 h-20 rounded-circle mr-1">
                        <span>{{ $assignee->name }}</span>
                    </a>
                    @endforeach
                </div>
            </th>
            <th>
                <span class="dropdown-toggle c-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="statusDropdown">Status</span>
                <div class="dropdown-menu" aria-labelledby="statusDropdown">
                    <span class="dropdown-item-text fz-12">Filter by status</span>
                    @foreach ($tags as $tag)
                        @php
                            $target = request()->fullUrlWithQuery(['tags' => [
                            $tag->id
                            ]]);
                            $class = in_array($tag->id, request()->get('tags') ?? []) ? 'visible' : 'invisible';
                        @endphp
                        <a class="dropdown-item d-flex align-items-center" href="{{ $target }}">
                            <i class="fa fa-check fz-12 mr-1 {{ $class }}"></i>
                            <div class="rounded w-13 h-13 d-inline-block mr-1"
                                style="background-color: {{$tag->background_color}};color: {{$tag->text_color}};"></div>
                            <span>{{ $tag->name }}</span>
                        </a>
                    @endforeach
                </div>
            </th>
        </thead>
        <tbody>
            @forelse ($applications as $application)
                @include('hr::application.render-application-row')
            @empty
            <tr>
                <td colspan="100%" class="text-center">No application found for this filter.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $applications->links() }}
</div>

@endsection
