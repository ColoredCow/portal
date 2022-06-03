@extends('efforttracking::layouts.master')
@section('content')

<div class="project-effort-tracking-container container py-10">
    <a href="{{ URL::previous() }}" class="text-theme-body text-decoration-none mb-2 mb-xl-4 d-flex align-items-center">
        <span class="mr-1 d-inline-flex w-8 h-8 w-xl-12 h-xl-12">
            {!! file_get_contents(public_path('icons/prev-icon.svg')) !!}
        </span>
        <span>All Projects</span>
    </a>

    <div class="card">
        <div class="card-header d-flex flex-row justify-content-between">
            <h2>{{ $project->name }} - Effort Details for {{ $currentMonth }}</h4>
            <div>
            <h2 class="fz-18 leading-22">Current Hours: <span>{{ $project->current_hours_for_month }}</span></h2>
            <h2 class="fz-18 leading-22" id="projectHours">Expected Hours: <span>{{ $project->current_expected_hours }}</span></h2>
            <h2 class="fz-18 leading-22" id="projectHours">Velocity: <span>{{ $project->velocity }}</span></h2>
            </div>
        </div>
        <div class="effort-tracking-data">
            <div class="d-flex flex-row p-5 d-flex justify-content-center">
                <div class="d-flex flex-column mr-3 form-group">
                    <label>Start date</label>
                    <input type="date" name="start_date" disabled="disabled" value="{{ $startDate->toDateString() }}">
                </div>
                <div class="d-flex flex-column ml-3">
                    <label>End date</label>
                    <input type="date" name="end_date" disabled="disabled" value="{{ $endDate->toDateString() }}">
                </div>
            </div>
            @if($project->current_hours_for_month === 0)
                <h2 class="text-center pb-6 font-weight-bold text-uppercase text-danger">No data available</h2>
            @else
                <div class="mt-4">
                    <input type="hidden" name="team_members_effort" value="{{$teamMembersEffort}}">
                    <input type="hidden" name="workingDays" value="{{$workingDays}}">
                    <input type="hidden" name="users" value="{{$users}}">
                    <canvas class="w-full" id="effortTrackingGraph"></canvas>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="project-resource-effort-tracking-container container mt-4 pb-10">
    <div class="card">
        <div class="card-header">
            <h4>{{$project->name}} - Members</h4>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Actual Effort</th>
                        <th scope="col">Expected Effort</th>
                        <th scope="col">Velocity</th>
                        <th scope="col">FTE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($project->getTeamMembers as $teamMember)
                        <tr>
                            <th scope="row" id="user-name<?php echo $teamMember->user->id; ?>">{{$teamMember->user->name}}</th>
                            <td>{{$teamMember->current_actual_effort}}</td>
                            <td>{{$teamMember->current_expected_effort}}</td>
                            <td class="{{ $teamMember->velocity >= 1 ? 'text-success' : 'text-danger' }}">{{$teamMember->velocity}}</td>
                            <td>{{$teamMember->user->fte}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
