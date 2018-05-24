@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.menu')
    <br><br>
    <h1>Applications</h1>
    <br>
    <div class="d-flex align-items-center justify-content-between">
        <ul class="nav nav-pills mb-2">
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status ? 'text-info' : 'active bg-info text-white' }}" href="/hr/applications"><i class="fa fa-clipboard"></i>&nbsp;Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link {{ $status === config('constants.hr.status.rejected.label') ? 'active bg-info text-white' : 'text-info' }}" href="/hr/applications?status={{ config('constants.hr.status.rejected.label') }}"><i class="fa fa-times-circle"></i>&nbsp;Rejected</a>
            </li>
       </ul>
        @if($GetApplicationType == 'job')
        <div class="alert alert-info mb-2 p-2">
            <span>There are <b>{{ $openJobsCount }}</b> open jobs and <b>{{ $applications->total() }}</b> open applications</span>
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
