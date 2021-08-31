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
    <div class="d-flex bg-white status-icons ">
        <ul class="nav mb-2 d-flex justify-content-between">
            <li class="nav-item mx-3">
                <a class="nav-item nav-link d-flex flex-column align-items-center px-0 {{!$status || $status === config('constants.hr.status.new.label') ? 'active text-theme-gray-dark' : 'text-theme-gray-light' }}"
                    href=/{{ Request::path() }}?status={{ config('constants.hr.status.new.label') }}{{$query_filters}}>
                    <div class="position-relative">

                        <span
                            class=" d-inline-block py-0"
                            style="font-family: 'Mulish', sans-serif; font-size: 10px;font-weight:700;line-height:12px;position: absolute;top: -10px;right: -1px;">
                            {{$newApplicationsCount + $inProgressApplicationsCount - $trialProgramCount}}
                        </span>
                        <i class="fa fa-user-o fa-2x" aria-hidden="true"></i>
                    </div>
                    <span style="font-family: 'Mulish', sans-serif;">
                    Open
                    </span>
                      
                </a>
            </li>

            <li class="nav-item mx-3">
                <a class="nav-item nav-link d-flex flex-column align-items-center px-0 {{ $status === config('constants.hr.status.in-progress.label') ? 'active text-theme-gray-dark' : 'text-theme-gray-light' }}"
                    href=/{{ Request::path() }}?status={{ config('constants.hr.status.in-progress.label') }}{{$query_filters}}&round=Trial-Program>
                    <div class="position-relative">
                        <span
                            class="ml-1 d-inline-block py-0"
                            style="font-family: 'Mulish', sans-serif; font-size: 10px;font-weight:700;line-height:12px;position: absolute;top: -10px;right: -1px;">
                            {{$trialProgramCount}}
                        </span>
                        <span>
                            <i class="fa fa-angle-left fa-2x" aria-hidden="true"></i>
                            <i class="fa fa-angle-right fa-2x" aria-hidden="true"></i>
                        </span> 
                    </div>
                    <span style="font-family: 'Mulish', sans-serif;">
                    Trial Program
                    </span>
                </a>
            </li>

            <li class="nav-item mx-3">
                <a class="nav-item nav-link d-flex flex-column align-items-center px-0 {{ $status === config('constants.hr.status.on-hold.label') ?  'active text-theme-gray-dark' : 'text-theme-gray-light' }}"
                    href=/{{Request::path() .'?status='. config('constants.hr.status.on-hold.label')}}{{$query_filters}}>
                    <div class="position-relative">
                        <span
                            class="ml-1 d-inline-block py-0"
                            style="font-family: 'Mulish', sans-serif; font-size: 10px;font-weight:700;line-height:12px;position: absolute;top: -10px;right: -1px;">
                            {{$onHoldApplicationsCount}}
                        </span>
                        <i class="fa fa-pause-circle-o fa-2x" aria-hidden="true"></i>
                    </div> 
                    <span style="font-family: 'Mulish', sans-serif;">
                    On hold
                    </span>
                </a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-item nav-link d-flex flex-column align-items-center px-0 {{ $status === config('constants.hr.status.no-show.label') ?  'active text-theme-gray-dark' : 'text-theme-gray-light' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}{{$query_filters}}>
                    <div class="position-relative">
                        <span
                            class="ml-1 d-inline-block py-0"
                            style="font-family: 'Mulish', sans-serif; font-size: 10px;font-weight:700;line-height:12px;position: absolute;top: -10px;right: -1px;">
                            {{$noShowApplicationsCount+$noShowRemindedApplicationsCount}}
                        </span>
                        <i class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i>
                    </div>
                    <span style="font-family: 'Mulish', sans-serif;">
                    No show
                    </span>
                </a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-item nav-link d-flex flex-column align-items-center px-0 {{ $status === config('constants.hr.status.rejected.label') ? 'active text-theme-gray-dark' : 'text-theme-gray-light' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}{{$query_filters}}>
                    <div class="position-relative">
                        <span
                            class="ml-1 d-inline-block py-0"
                            style="font-family: 'Mulish', sans-serif; font-size: 10px;font-weight:700;line-height:12px;position: absolute;top: -10px;right: -1px;">
                            {{$rejectedApplicationsCount}}
                        </span>
                        <i class="fa fa-times fa-2x"></i>
                    </div>
                    <span style="font-family: 'Mulish', sans-serif;">
                    Closed
                    </span>
                </a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-item nav-link d-flex flex-column align-items-center px-0 {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active text-theme-gray-dark' : 'text-theme-gray-light' }}"
                    href= /{{ Request::path() .'?status='. config('constants.hr.status.sent-for-approval.label')}}{{$query_filters}}>
                    <div class="position-relative">
                        <span
                            class="ml-1 d-inline-block py-0"
                            style="font-family: 'Mulish', sans-serif; font-size: 10px;font-weight:700;line-height:12px;position: absolute;top: -10px;right: -1px;">
                            {{$sentForApprovalApplicationsCount}}
                        </span>
                        <i class="fa fa-clock-o fa-2x" aria-hidden="true"></i>
                    </div>
                    
                    <span style="font-family: 'Mulish', sans-serif;">
                    To approve
                    </span>
                </a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-item nav-link d-flex flex-column align-items-center px-0 {{ $status === config('constants.hr.status.approved.label') ?  'active text-theme-gray-dark' : 'text-theme-gray-light' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.approved.label') }}{{$query_filters}}>
                    <div class="position-relative">
                        <span
                            class="ml-1 d-inline-block py-0"
                            style="font-family: 'Mulish', sans-serif; font-size: 10px;font-weight:700;line-height:12px;position: absolute;top: -10px;right: -1px;">
                            {{$approvedApplicationsCount}}
                        </span>
                        <span class="fa-stack">
                            <i class="fa fa-user-o fa-stack-2x" aria-hidden="true"></i>
                            <i class="fa fa-check fa-stack-lg pl-5" aria-hidden="true"></i>
                        </span> 
                    </div>
                    <span style="font-family: 'Mulish', sans-serif;">
                    Approved
                    </span>  
                </a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-item nav-link d-flex flex-column align-items-center px-0 {{ $status === config('constants.hr.status.onboarded.label') ? 'active text-theme-gray-dark' : 'text-theme-gray-light' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.onboarded.label') }}{{$query_filters}}>
                    <div class="position-relative">
                        <span
                            class="ml-1 d-inline-block py-0"
                            style="font-family: 'Mulish', sans-serif; font-size: 10px;font-weight:700;line-height:12px;position: absolute;top: -10px;right: -1px;">
                            {{$onboardedApplicationsCount}}
                        </span>
                        <i class="fa fa-clipboard fa-2x" aria-hidden="true"></i>
                    </div>
                    <span style="font-family: 'Mulish', sans-serif;">
                    Onboard
                    </span> 
                </a>
            </li>
        </ul>
        @if( isset($openJobsCount, $openApplicationsCount) )
        <div class="alert alert-info mb-2 p-2">
            <span>There are <b>{{ $openJobsCount }}</b> open jobs and <b>{{ $newApplicationsCount }}</b> open
                applications</span>
        </div>
        @endif
    </div>
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

@include('hr.application.excel-import')
@endsection