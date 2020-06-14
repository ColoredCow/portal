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

        <div class="col-md-6 text-right text-underline">
            <a href="{{ route('hr.applicant.create') }}" class="btn btn-primary text-white">Add new application</a>
            <button data-toggle="modal" data-target="#excelImport" class="btn btn-primary text-white">Import excel file</button>
        </div>
    </div>

    <div class="row mt-4">
        <form class="col-md-4 d-flex justify-content-end align-items-center" method="GET" action="/{{ Request::path() }}">
            <input type="hidden" name="status" class="form-control" id="search" value=
                   "{{ config('constants.hr.status.' . request("status") . '.label') }}" >

        <input type="text" name="search" class="form-control" id="search" placeholder="Search Applicants" value=@if(request()->has('search')){{request()->get('search')}}
                   @endif>

               <button class="btn btn-info ml-2">Search</button>
            </form>
    </div>
    @if(request()->has('search'))
    <div class="row mt-3 mb-2">
        <div class="col-6">
            <a class="text-muted c-pointer" href="/{{ Request::path() }}{{request()->has('status')?'?status='.request('status'):''}}">
                <i class="fa fa-times"></i>&nbsp;Clear current search and filters
            </a>
        </div>
    </div>
    @endif
    <br>
    <div class="d-flex align-items-center justify-content-between">
        <ul class="nav nav-pills mb-2">
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status ? 'text-info' : 'active bg-info text-white' }}" href=/{{ Request::path() }}{{request()->has('search')? "?search=".request('search'):"" }}><i class="fa fa-clipboard"></i>&nbsp;
                Open
                @if(request()->has('search'))
                    <span class="ml-1 d-inline-block bg-info text-white px-2 py-0 {{ $status ? 'text-white' : 'active bg-white text-info' }}" style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                    {{$newApplicationsCount + $inProgressApplicationsCount }}
                    </span>
                @endif
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.on-hold.label') ? 'active bg-info text-white' : 'text-info' }}" href=/{{Request::path() .'?status='. config('constants.hr.status.on-hold.label')}}{{request()->has('search')? "&search=".request('search'):"" }}><i class="fa fa-file-text-o"></i>&nbsp;
                    {{ config('constants.hr.status.on-hold.title') }}
                @if(request()->has('search'))
                    <span class="ml-1 d-inline-block bg-info text-white px-2 py-0 {{ $status === config('constants.hr.status.on-hold.label') ? 'active bg-white text-info' : 'text-white' }}" style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$onHoldApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-info text-white' : 'text-info' }}" href= /{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}{{request()->has('search')? "&search=".request('search'):"" }}><i class="fa fa-warning"></i>&nbsp;{{ config('constants.hr.status.no-show.title') }} @if(request()->has('search'))
                    <span class="ml-1 d-inline-block bg-info text-white px-2 py-0 {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-white text-info' : 'text-white' }}" style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$noShowApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-info text-white' : 'text-info' }}" href= /{{ Request::path() }}?status={{ config('constants.hr.status.rejected.label') }}{{request()->has('search')? "&search=".request('search'):"" }}><i class="fa fa-times-circle"></i>&nbsp;
                    Closed
                @if(request()->has('search'))
                    <span class="ml-1 d-inline-block bg-info text-white px-2 py-0 {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-white text-info' : 'text-white' }}" style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$rejectedApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-info text-white' : 'text-info' }}" href= /{{ Request::path() .'?status='. config('constants.hr.status.sent-for-approval.label')}}{{request()->has('search')? "&search=".request('search'):"" }}
               ><i class="fa fa-clock-o"></i>&nbsp;{{ config('constants.hr.status.sent-for-approval.title') }}
                @if(request()->has('search'))
                    <span class="ml-1 d-inline-block bg-info text-white px-2 py-0 {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-white text-info' : 'text-white' }}" style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$sentForApprovalApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.approved.label') ? 'active bg-info text-white' : 'text-info' }}" href= /{{ Request::path() }}?status={{ config('constants.hr.status.approved.label') }}{{request()->has('search')? "&search=".request('search'):"" }}><i class="fa fa-check-square"></i>&nbsp;
                    Approved
                @if(request()->has('search'))
                    <span class="ml-1 d-inline-block bg-info text-white px-2 py-0 {{ $status === config('constants.hr.status.approved.label') ? 'active bg-white text-info' : 'text-white' }}" style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$approvedApplicationsCount}}
                    </span>
                @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link d-flex align-items-center {{ $status === config('constants.hr.status.onboarded.label') ? 'active bg-info text-white' : 'text-info' }}" href= /{{ Request::path() }}?status={{ config('constants.hr.status.onboarded.label') }}{{request()->has('search')? "&search=".request('search'):"" }}><i class="fa fa-certificate"></i>&nbsp;
                    Onboard
                @if(request()->has('search'))
                    <span class="ml-1 d-inline-block bg-info text-white px-2 py-0 {{ $status === config('constants.hr.status.onbaorded.label') ? 'active bg-white text-info' : 'text-white' }}" style="border-radius: 20px;font-size: 12px;font-weight: 700;">
                        {{$onboardedApplicationsCount}}
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

@include('hr.application.excel-import')
@endsection
