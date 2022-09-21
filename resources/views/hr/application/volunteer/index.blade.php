@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="d-flex p-2 bd-highlight justify-content-between"">
        <div>
            @include('hr.volunteers.menu')
        </div>
        <div>
            <form method="get" action="{{ route('addUser') }}">       
                <button class="btn btn-success text-white ml-1"><i class="fa fa-plus"></i>Add new Volunteer</button>
            </form>
        </div>
    </div>
        
        
    <br><br>

    
    <div class="row">
        <div class="col-md-6">
            <h1>Volunteering Applications</h1>
            
            
        </div>
        <form class="offset-md-2 col-md-4 d-flex justify-content-end align-items-center" method="GET" action="/{{ Request::path() }}">
            
            <input type="hidden" name="status" class="form-control" id="search" value=
                @switch(request('status'))
                    @case('on-hold')
                        {{ config('constants.hr.status.on-hold.label') }}
                    @case('rejected')
                        {{ config('constants.hr.status.rejected.label') }}
                    @case('sent-for-approval')
                        {{ config('constants.hr.status.sent-for-approval.title') }}
                    @case('no-show')
                        {{ config('constants.hr.status.no-show.label') }}
                    @endswitch>
           <input type="text" name="search" class="form-control" id="search" placeholder="Search volunteers">
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
                <a class="nav-item nav-link {{ $status ? 'text-info' : 'active bg-info text-white' }}" href="/{{ Request::path() }}/"><i class="fa fa-clipboard"></i>&nbsp;Open</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === config('constants.hr.status.sent-for-approval.label') ? 'active bg-info text-white' : 'text-info' }}" href="/{{ Request::path() }}?status={{ config('constants.hr.status.sent-for-approval.label') }}"><i class="fa fa-clock-o"></i>&nbsp;{{ config('constants.hr.status.sent-for-approval.title') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === config('constants.hr.status.on-hold.label') ? 'active bg-info text-white' : 'text-info' }}" href="/{{ Request::path() }}?status={{ config('constants.hr.status.on-hold.label') }}"><i class="fa fa-file-text-o"></i>&nbsp;{{ config('constants.hr.status.on-hold.title') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === config('constants.hr.status.no-show.label') ? 'active bg-info text-white' : 'text-info' }}" href="/{{ Request::path() }}?status={{ config('constants.hr.status.no-show.label') }}"><i class="fa fa-warning"></i>&nbsp;{{ config('constants.hr.status.no-show.title') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === 'closed' ? 'active bg-info text-white' : 'text-info' }}" href="/{{ Request::path() }}?status=closed"><i class="fa fa-times-circle"></i>&nbsp;Closed</a>
            </li>
        </ul>
        @if( isset($openJobsCount, $openApplicationsCount) )
        <div class="alert alert-info mb-2 p-2">
            <span>There are <b>{{ $openJobsCount }}</b> open jobs and <b>{{ $openApplicationsCount }}</b> open applications</span>
        </div>
        @endif
    </div>

    <table class="table table-striped table-bordered" id="applicants_table">
        <thead class="thead-dark">
        <tr class="sticky-top">
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
