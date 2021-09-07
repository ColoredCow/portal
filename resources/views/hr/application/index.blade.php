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
    <!-- <div class="row mt-4">
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
    @endphp -->
    <div class="d-flex align-items-center justify-content-between appli">
        <ul class="nav nav-pills mb-2">
            <li class="nav-item">    
                <a class="nav-item nav-link d-flex align-items-center {{ $status ? 'text-info' : 'bg-info text-white' }}"
                    href=/{{ Request::path() }}?status={{ config('constants.hr.status.new.label') }}{{$query_filters}}> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="" class="bi bi-people" color="black" viewBox="0 0 16 16"><path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>&nbsp;
                    <h1 class="open">Open</h1>
                    </svg>&nbsp;
                    <span
                        class="ml-1 d-inline-block px-2 py-0 head {{ $status ? ' bg-transparent text-info' : 'bg-transparent text-dark' }}"
                        style="border-radius: 20px; font-size:16px; font-weight: 700; font-color:black;">
                        {{$newApplicationsCount + $inProgressApplicationsCount - $trialProgramCount}}
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.in-progress.label') ? 'bg-info text-white' : 'text-info' }}"
                    href=/{{ Request::path() }}?status={{ config('constants.hr.status.in-progress.label') }}{{$query_filters}}&round=Trial-Program>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="" class="bi bi-code trial" viewBox="0 0 16 16"><path d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8l3.147-3.146zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8l-3.147-3.146z"/></svg>
                    <h2 class="trial-program">TrialProgram</h2>
                    <span
                        class="ml-1 d-inline-block head1{{ request()->get('round')=='Trial-Program' ? 'bg-white text-info' : '' }}"
                        style="border-radius: 20px;font-size: 16px;font-weight: 700;">
                        {{$trialProgramCount}}
                    </span>
                </a>
            </li>

            <li class="nav-item hold">
                <a class="nav-item nav-link d-flex align-items-center{{ $status === config('constants.hr.status.on-hold.label') ? 'bg-info text-white' : 'text-info' }}"
                    href=/{{Request::path() .'?status='. config('constants.hr.status.on-hold.label')}}{{$query_filters}}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="" class="bi bi-pause-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M5 6.25a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0v-3.5zm3.5 0a1.25 1.25 0 1 1 2.5 0v3.5a1.25 1.25 0 1 1-2.5 0v-3.5z"/></svg>
                    {{ config('constants.hr.status.on-hold.title') }}
                    <span
                        class="ml-1 d-inline-block {{ $status === config('constants.hr.status.on-hold.label') ? 'bg-white text-info' : '' }}"
                        style="border-radius: 20px;font-size: 16px;font-weight: 700;">
                        {{$onHoldApplicationsCount}}
                    </span>
                </a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}{{$query_filters}}>
                    <i class="fa fa-warning"></i>&nbsp;{{ config('constants.hr.status.no-show.title') }}
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-white text-info' : '' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$noShowApplicationsCount+$noShowRemindedApplicationsCount}}
                    </span>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}{{$query_filters}}>
                    <i class="fa fa-times-circle"></i>&nbsp;
                    Closed
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-white text-info' : '' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$rejectedApplicationsCount}}
                    </span>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() .'?status='. config('constants.hr.status.sent-for-approval.label')}}{{$query_filters}}>
                    <i class="fa fa-clock-o"></i>&nbsp;{{ config('constants.hr.status.sent-for-approval.title') }}
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-white text-info' : '' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$sentForApprovalApplicationsCount}}
                    </span>
                </a>
            </li> -->
            <!-- <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.approved.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.approved.label') }}{{$query_filters}}>
                    <i class="fa fa-check-square"></i>&nbsp;
                    Approved
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.approved.label') ? 'active bg-white text-info' : 'bg-info text-white' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$approvedApplicationsCount}}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.onboarded.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.onboarded.label') }}{{$query_filters}}>
                    <i class="fa fa-certificate"></i>&nbsp;
                    Onboard
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.onboarded.label') ? 'active bg-white text-info' : 'bg-info text-white' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$onboardedApplicationsCount}}
                    </span>
                </a>
            </li> -->
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

@include('hr.application.excel-import')
@endsection