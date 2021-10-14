@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.menu')
    <br>
    <div class="row">
        <div class="col-md-6">
            <h1>Applications</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('hr.applicant.create') }}" class="btn btn-primary text-white">Add new application</a>
            <button data-toggle="modal" data-target="#excelImport" class="btn btn-primary text-white">Import excel file</button>
        </div>
    </div>
        <div class="input-group col-md-6 align-self-center">
            <form method="GET" action="/{{ Request::path() }}">  
                <input type="hidden" name="status" class="form-control" id="search"
                    value="{{ config('constants.hr.status.' . request("status") . '.label') }}">
    
                <input type="hidden" name="round" class="form-control" id="search"
                    value=@if(request()->has('round')){{request()->get('round')}}@endif>
                    {{-- <div class="input-group-prepend">
                        <span>{!! file_get_contents(public_path('icons/funnel-fill.svg')) !!}</span>
                    </div> --}}
                    <input
                        type="text" name="search" class="form-control w-300" id="search" placeholder="Enter a keyword"
                        value= @if(request()->has('search')){{request()->get('search')}}@endif>
                    {{-- <div class="input-group-append">
                        <span>{!! file_get_contents(public_path('icons/funnel-fill.svg')) !!}</span>
                    </div>  --}}
            </form>
            {{-- <div class="input-group-append">
                <span>{!! file_get_contents(public_path('icons/funnel-fill.svg')) !!}</span>
            </div> --}}
            <div class="col-md-2 align-self-center">    
                <button class="btn btn-info ml-2">Search</button>
            </div>
            <div class="input-group-append">
                <span class="funnel-icon" data-toggle="modal" data-target="#myModal">{!! file_get_contents(public_path('icons/funnel-fill.svg')) !!}</span>
            </div> 
        </div>
  
  <!-- The Modal -->
    <div class="modal job-application-modal" id="myModal">
        <div class="modal-dialog">
        <div class="modal-content">
    
            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Filter By</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
    
            <!-- Modal body -->
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <job-application-component :options="options"></job-application-component>    
                        </div>
                    </div>
                </form>     
            </div>
    
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Apply</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
            </div>
    
        </div>
        </div>
  </div>
    @if(request()->has('search') || request()->has('tags'))
    <div class="row mt-3 mb-2">
        <div class="col-6">
            <a class="text-muted c-pointer"
                href="/{{ Request::path() }}{{request()->has('status')?'?status='.request('status'):''}}{{request()->has('round')?'&round='.request('round'):''}}">
                <i class="fa fa-times"></i>
                <span>Clear current search and filters</span>
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
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/people.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.new.label') ? 'text-underline' : ( isset($status) ? '' : 'text-underline' ) }}">Open</h5>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class="{{ $status === config('constants.hr.status.in-progress.label') ? 'job-application-status' : '' }} btn" 
                href=/{{ Request::path() }}?status={{ config('constants.hr.status.in-progress.label') }}{{$query_filters}}&round=trial-program>
                    <sup class = "application-menu-options-title fz-18">
                        {{$trialProgramCount}}
                    </sup>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/code.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.in-progress.label') ? 'text-underline' : '' }}">Trial Program</h5>    
                </a>
            </li>
            <li id="list-styling">
                <a class="{{ $status === config('constants.hr.status.on-hold.label') ? 'job-application-status' : '' }} btn" 
                href=/{{Request::path() .'?status='. config('constants.hr.status.on-hold.label')}}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18">
                        {{$onHoldApplicationsCount}}
                    </sup>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/pause-circle.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.on-hold.label') ? 'text-underline' : '' }}">On Hold</h5>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class="{{ $status === config('constants.hr.status.no-show.label') ? 'job-application-status':'' }} btn"
                href= /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18">
                        {{$noShowApplicationsCount+$noShowRemindedApplicationsCount}}
                    </sup>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/exclamation-octagon-fill.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.no-show.label') ? 'text-underline':'' }}">No Show</h5>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class="{{ $status === config('constants.hr.status.sent-for-approval.label') ? 'job-application-status' : '' }} btn"
                href= /{{ Request::path() .'?status='. config('constants.hr.status.sent-for-approval.label')}}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18">
                        {{$sentForApprovalApplicationsCount}}
                    </sup>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/clipboard.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'text-underline' : '' }}">To Approve</h5>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class= "{{ $status === config('constants.hr.status.approved.label') ? 'job-application-status' : '' }} btn"
                href= /{{ Request::path() }}?status={{ config('constants.hr.status.approved.label') }}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18">
                        {{$approvedApplicationsCount}}
                    </sup>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/clipboard-check.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.approved.label') ? 'text-underline' : '' }}">Approved</h5>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class="{{ $status === config('constants.hr.status.onboarded.label') ? 'job-application-status' : '' }} btn"
                href= /{{ Request::path() }}?status={{ config('constants.hr.status.onboarded.label') }}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18" >
                        {{$onboardedApplicationsCount}}
                    </sup>
                    <span class="d-inline-block h-26 w-26"> {!! file_get_contents(public_path('icons/person-check.svg')) !!} </span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.onboarded.label') ? 'text-underline' : '' }}">On Boarded</h5>
                </a>
            </li>
            <li id="list-styling">
                <a id="job-application-listings" class= "{{ $status === config('constants.hr.status.rejected.label') ? 'job-application-status':'' }} btn"
                href= /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}{{$query_filters}}>
                    <sup class = "application-menu-options-title fz-18" >
                        {{$rejectedApplicationsCount}}    
                    </sup>
                    <span class="d-inline-block h-26 w-26">{!! file_get_contents(public_path('icons/x-circle.svg')) !!}</span>
                    <h5 class="application-menu-headings fz-20 font-mulish {{ $status === config('constants.hr.status.rejected.label') ? 'text-underline':'' }}">Closed</h5>
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
    <div class="table">
        <table class="table table-striped" id="applicants_table">
            <thead>
                <th class="name">Name</th>
                <th class="details">Details</th>
                <th>
                    <span class="dropdown-toggle c-pointer assignee" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="assigneeDropdown">Assignee</span>
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
                    <span class="dropdown-toggle c-pointer status" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="statusDropdown">Status</span>
                    <div class="dropdown-menu" aria-labelledby="statusDropdown">
                        <span class="dropdown-item-text fz-12">Filter by status</span>
                        @foreach ($tags as $tag)
                            @php
                                $target = request()->fullUrlWithQuery(['tags' => [$tag->id]]);
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
</div>

@include('hr.application.excel-import')

@endsection

