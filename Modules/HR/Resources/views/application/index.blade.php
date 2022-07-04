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
            <button class="btn btn-info ml-2 ">Search</button>
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
    <div class="d-flex align-items-center justify-content-between">
        <ul class="nav nav-pills mb-2">
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status ? 'text-info' : 'active bg-info text-white' }}"
                    href=/{{ Request::path() }}{{request()->has('search')? "?search=".request('search'):"" }}> <i
                    class="fa fa-clipboard"></i>&nbsp;
                    Open
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status ? 'bg-info text-white' : 'active bg-white text-info' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$newApplicationsCount + $inProgressApplicationsCount - $trialProgramCount}}
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.in-progress.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href=/{{ Request::path() }}?status={{ config('constants.hr.status.in-progress.label') }}{{request()->has('search')? "&search=".request('search'):"" }}&round=Trial-Program>
                    <i class="fa fa-clipboard"></i>&nbsp;
                    Trial Program
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ request()->get('round')=='Trial-Program' ? 'active bg-white text-info' : 'bg-info text-white' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$trialProgramCount}}
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.on-hold.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href=/{{Request::path() .'?status='. config('constants.hr.status.on-hold.label')}}{{request()->has('search')? "&search=".request('search'):"" }}>
                    <i class="fa fa-file-text-o"></i>&nbsp;
                    {{ config('constants.hr.status.on-hold.title') }}
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.on-hold.label') ? 'active bg-white text-info' : 'bg-info text-white' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$onHoldApplicationsCount}}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}{{request()->has('search')? "&search=".request('search'):"" }}>
                    <i class="fa fa-warning"></i>&nbsp;{{ config('constants.hr.status.no-show.title') }}
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-white text-info' : 'bg-info text-white' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$noShowApplicationsCount}}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}{{request()->has('search')? "&search=".request('search'):"" }}>
                    <i class="fa fa-times-circle"></i>&nbsp;
                    Closed
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-white text-info' : 'bg-info text-white' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$rejectedApplicationsCount}}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() .'?status='. config('constants.hr.status.sent-for-approval.label')}}{{request()->has('search')? "&search=".request('search'):"" }}>
                    <i class="fa fa-clock-o"></i>&nbsp;{{ config('constants.hr.status.sent-for-approval.title') }}
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-white text-info' : 'bg-info text-white' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$sentForApprovalApplicationsCount}}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.approved.label') ? 'active bg-info text-white' : 'text-info' }}"
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.approved.label') }}{{request()->has('search')? "&search=".request('search'):"" }}>
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
                    href= /{{ Request::path() }}?status={{ config('constants.hr.status.onboarded.label') }}{{request()->has('search')? "&search=".request('search'):"" }}>
                    <i class="fa fa-certificate"></i>&nbsp;
                    Onboard
                    <span
                        class="ml-1 d-inline-block px-2 py-0 {{ $status === config('constants.hr.status.onboarded.label') ? 'active bg-white text-info' : 'bg-info text-white' }}"
                        style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$onboardedApplicationsCount}}
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