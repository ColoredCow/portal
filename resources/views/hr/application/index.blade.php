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
    <div class="row mt-4">
        <form class="col-md-5 d-flex justify-content-end align-items-center" method="GET" action="/{{ Request::path() }}">  
            <input type="hidden" name="status" class="form-control" id="search"
                value="{{ config('constants.hr.status.' . request("status") . '.label') }}">

            <input type="hidden" name="round" class="form-control" id="search"
                value=@if(request()->has('round')){{request()->get('round')}}@endif>

            <input 
                type="text" name="search" class="form-control" id="search" placeholder="Name, email, phone, or university"
                value=@if(request()->has('search')){{request()->get('search')}}@endif>
            <button class="btn btn-info ml-2">Search</button>
        </form>
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
                <a class="btn" id="job-application-listings" {{ $status}}
                    href=/{{ Request::path() }}?status={{ config('constants.hr.status.new.label') }}{{$query_filters}} >
                    <sup class="head1">
                        {{$newApplicationsCount + $inProgressApplicationsCount - $trialProgramCount}}
                    </sup>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people opened" viewBox="0 0 16 16"><path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>&nbsp;
                    <h5 class="open" id="text2">Open</h5>
                </a>
            </li>
            <li id="list-styling">
                <a  class="btn" id="job-application-listings"
                    href=/{{ Request::path() }}?status={{ config('constants.hr.status.in-progress.label') }}{{$query_filters}}&round=Trial-Program data-spy="affix" data-offset-top="197">
                    <sup class = "head1">
                        {{$trialProgramCount}}
                    </sup>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"  fill="currentColor" class="bi bi-code trial"  viewBox="0 0 16 16"><path d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8l-3.147-3.146z"/></svg>
                    <h5 class="trial-program" id="text1">Trial Program</h5>
                    {{ request()->get('round')=='Trial-Program' ? '' : '' }}
                </a>
            </li>
            <li id="list-styling">
                <a class="btn" id="job-application-listings"
                    href=/{{Request::path() .'?status='. config('constants.hr.status.on-hold.label')}}{{$query_filters}}>
                    <sup class ="head1">
                        {{$onHoldApplicationsCount}}
                    </sup>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pause-circle hold" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M5 6.25a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0v-3.5zm3.5 0a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0v-3.5z"/></svg>
                    <h5 class="on-hold">On Hold</h5>
                    {{ $status === config('constants.hr.status.on-hold.label') ? '' : '' }}
                </a>
            </li>
            <li id="list-styling">
                <a class="btn" id="job-application-listings"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}{{$query_filters}}>
                    <sup class="head1">
                        {{$noShowApplicationsCount+$noShowRemindedApplicationsCount}}
                    </sup>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-octagon no" viewBox="0 0 16 16"><path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/><path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/></svg>
                    <h5 class="no-show">No Show</h5>
                </a>
            </li>
            <li id="list-styling">
                <a class="btn" id="job-application-listings"
                    href= /{{ Request::path() .'?status='. config('constants.hr.status.sent-for-approval.label')}}{{$query_filters}}>
                    <sup class="head1">
                        {{$sentForApprovalApplicationsCount}}
                    </sup>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clipboard approve" viewBox="0 0 16 16"><path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/><path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/></svg>
                    <h5 class="toapprove">To Approve</h5>
                </a>
            </li>
            <li id="list-styling">
                <a class="btn" id="job-application-listings"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.approved.label') }}{{$query_filters}}>
                    <sup class = "head1">
                        {{$approvedApplicationsCount}}
                    </sup>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-check approval" viewBox="0 0 16 16"><path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/><path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/></svg>
                    <h5 class="approved">Approved</h5>
                </a>
            </li>
            <li id="list-styling">
                <a class="btn" id="job-application-listings"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.onboarded.label') }}{{$query_filters}}>
                    <sup class = "head1">
                        {{$onboardedApplicationsCount}}
                    </sup>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-clipboard-check onboard" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/><path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/><path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/></svg>
                    <h5 class="onboarded">On Boarded</h5>
                </a>
            </li>
            <li id="list-styling">
                <a class="btn" id="job-application-listings"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}{{$query_filters}}>
                    <sup class = "head1">
                        {{$rejectedApplicationsCount}}    
                    </sup>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/></svg>
                    <h5 class="closed">Closed</h5>
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
                                $target = request()->fullUrlWithQuery(['tags' => [
                                $tag->id
                                ]]);
                                $class = in_array($tag->id, request()->get('tags') ?? []) ? 'visible' : 'invisible';
                            @endphp
                            <a class="dropdown-item d-flex align-items-center" href="{{ $target }}">
                                <i class="fa fa-check fz-12 mr-1 {{ $class }}"></i>
                                <div class="rounded w-13 h-13 d-inline-block mr-1"
                                    style="background-color: {{$tag->background_color}};color: {{$tag->text_color}};"></div>
                                <span>{{ $tag->tag_name }}</span>
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

