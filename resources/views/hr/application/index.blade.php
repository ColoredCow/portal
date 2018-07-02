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
        <form class="offset-md-2 col-md-4 d-flex justify-content-end align-items-center" method="GET" action="/{{ Request::path() }}">
            <input type="hidden" name="status" class="form-control" id="search" value=
                @switch(request('status'))
                    @case('on-hold')
                        {{ config('constants.hr.status.on-hold.label') }}
                    @case('rejected')
                        {{ config('constants.hr.status.rejected.label') }}
                    @case('sent-for-approval')
                        {{ config('constants.hr.status.sent-for-approval.label') }}
                    @case('no-show')
                        {{ config('constants.hr.status.no-show.label') }}
                    @endswitch>

        <input type="text" name="search" class="form-control" id="search" placeholder="Search Applicants" value=@if(request()->has('search')){{request()->get('search')}}
                   @endif>

               <button class="btn btn-info ml-2">Search</button>
            </form>
    </div>
    @if(request()->has('search'))
    <div class="row mt-3 mb-2">
        <div class="col-6">
            <a class="text-muted c-pointer" href="/{{ Request::path() }}?status={{request('status')}}">
                <i class="fa fa-times"></i>&nbsp;Clear current search and filters
            </a>
        </div>
    </div>
    @endif
    <br>
    <div class="d-flex align-items-center justify-content-between">
        <ul class="nav nav-pills mb-2">
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status ? 'text-info' : 'active bg-info text-white' }}" href=
                @if(request()->has('search'))
                    /{{ Request::path() }}?search={{request('search')}}
                @else
                    /{{ Request::path() }}
                @endif><i class="fa fa-clipboard"></i>&nbsp;
                Open
                @if(request()->has('search'))
                    <span class="ml-2 d-inline-block bg-info text-white px-2 py-1 {{ $status ? 'text-white' : 'active bg-white text-info' }}" style="   border-radius: 20px;font-size: 12px;font-weight: 700;">
                    {{$newApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-info text-white' : 'text-info' }}" href=
                @if(request()->has('search'))
                    /{{ Request::path() }}?status={{ config('constants.hr.status.sent-for-approval.label') }}&search={{request('search')}}
                @else
                    /{{ Request::path() }}?status={{ config('constants.hr.status.sent-for-approval.label') }}
                @endif><i class="fa fa-clock-o"></i>&nbsp;{{ config('constants.hr.status.sent-for-approval.title') }}
                @if(request()->has('search'))
                    <span class="ml-2 d-inline-block bg-info text-white px-2 py-1 {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-white text-info' : 'text-white' }}" style="   border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$sentForApprovalApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === config('constants.hr.status.on-hold.label') ? 'active bg-info text-white' : 'text-info' }}" href=
                @if(request()->has('search'))
                /{{ Request::path() }}?status={{ config('constants.hr.status.on-hold.label') }}&search={{request('search')}}
                @else
                /{{ Request::path() }}?status={{ config('constants.hr.status.on-hold.label') }}
                @endif><i class="fa fa-file-text-o"></i>&nbsp;
                    {{ config('constants.hr.status.on-hold.title') }}
                @if(request()->has('search'))
                    <span class="ml-2 d-inline-block bg-info text-white px-2 py-1 {{ $status === config('constants.hr.status.on-hold.label') ? 'active bg-white text-info' : 'text-white' }}" style="   border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$onHoldApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-info text-white' : 'text-info' }}" href=
                @if(request()->has('search'))
                    /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}&search={{request('search')}}
                @else
                    /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}
                @endif><i class="fa fa-warning"></i>&nbsp;{{ config('constants.hr.status.no-show.title') }} @if(request()->has('search'))
                    <span class="ml-2 d-inline-block bg-info text-white px-2 py-1 {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-white text-info' : 'text-white' }}" style="   border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$noShowApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-info text-white' : 'text-info' }}" href=
                @if(request()->has('search'))
                    /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}&search={{request('search')}}
                @else
                    /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}
                @endif><i class="fa fa-times-circle"></i>&nbsp;
                    Closed
                @if(request()->has('search'))
                    <span class="ml-2 d-inline-block bg-info text-white px-2 py-1 {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-white text-info' : 'text-white' }}" style="   border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$rejectedApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
        </ul>
        @if( isset($openJobsCount, $openApplicationsCount) )
        <div class="alert alert-info mb-2 p-2">
            <span>There are <b>{{ $openJobsCount }}</b> open jobs and <b>{{ $newApplicationsCount }}</b> open applications</span>
        </div>
        @endif
    </div>

    <table class="table table-striped table-bordered" id="applicants_table">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Applied for</th>
            <th>Applied on</th>
            <th>Status</th>
        </tr>
        @foreach ($applications as $application)
        <tr>
            <td>
                <a href="/{{ Request::path() }}/{{ $application->id }}/edit">{{ $application->applicant->name }}</a>
            </td>
            <td>{{ $application->applicant->email }}</td>
            <td>{{ $application->job->title }}</td>
            <td>{{ $application->created_at->format(config('constants.display_date_format')) }}</td>
            <td>
                <span class="d-flex justify-content-start">
                    @if (in_array($application->status, ['in-progress', 'new']))
                        <span class="badge badge-warning badge-pill">{{ $application->applicationRounds->last()->round->name }}</span>
                        @if ($application->applicationRounds->count() > 1)
                            <span class="badge badge-info badge-pill ml-1 px-2">Completed: {{ $application->applicationRounds->count() - 1 }}</span>
                        @else
                            <span class="badge badge-info badge-pill ml-1 px-2">New</span>
                        @endif
                    @else
                        <span class="{{ config("constants.hr.status.$application->status.class") }} badge-pill">{{ config("constants.hr.status.$application->status.title") }}</span>
                    @endif
                </span>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $applications->links() }}
</div>
@endsection
