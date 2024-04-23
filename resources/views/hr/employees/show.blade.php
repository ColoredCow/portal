@extends('report::layouts.master')
@section('content')

<div class="container">
    <br>
    <h4 class="mb-5 font-weight-bold">Employee Details</h4>
        @include('hr.employees.sub-views.menu', $employee)
    <br>
    <div class="mt-4 card">
        <div class="card-body">
            <div class="d-flex justify-content-between mx-5 align-items-end">
                <div class="col">
                    <div class="mt-2"><h1>{{$employee->name}}</h1>
                      <span class="ml-1"><a href={{ route('employees.employeeWorkHistory', $employee->id) }}>Work History</a></span>
                    </div>
                    @if ($employee->designation_id)
                        <div class="row ml-1">
                            <span class="font-weight-bold">Designation:</span>&nbsp;<p>{{$employee->hrJobDesignation->designation}}</p>
                        </div>
                        <div class="row ml-1">
                            <span class="font-weight-bold">Domain:</span>&nbsp;<p>{{optional(optional($employee->hrJobDesignation)->hrJobDesignationDomain)->domain}}</p>
                        </div>
                    @endif
                </div>
                @if(optional($user)->avatar)
                    <img src="{{ $user->avatar }}" class="w-100 h-100 rounded-circle">
                @endif
            </div>
            <hr class='bg-dark mx-4 pb-0.5'>
            <div class=""><div class="font-weight-bold fz-24 pl-5 mt-5 mb-3 d-flex">{{__('Current FTE: ')}}<div class=" ml-1 {{ $user ? (($user->ftes['main'] + $user->ftes['amc']) > 1 ? 'text-success' : 'text-danger') : 'text-secondary'}} font-weight-bold">{{ $user ? ($user->ftes['main'] + $user->ftes['amc'])  :'NA' }}</div></div>
            <div>
                <canvas class="w-full" id="userDashboardGraph"></canvas>
                <input type="hidden" id="get_report_data_url" value={{ route('reports.fte.get-report-data', ['userId' => $user->id]) }}>

            @if ($employee->user)
                <div class="font-weight-bold fz-24 pl-5 mt-5 mb-3">Active Project Details</div>
                <div class="mx-5">
                    <table class="table">
                        <thead>
                            <tr class="bg-theme-gray text-light">
                                <th scope="col" class="pb-3 lg-4"><div class="ml-2">Project Name</div></th>
                                <th scope="col" class="pb-3 lg-4">Project Term</th>
                                <th scope="col" class="lg-4">Expected Hours For Term</th>
                                <th scope="col" class="lg-4">Expected Hours Till Today</th>
                                <th scope="col" class="lg-4">Billable Effort</th>
                                <th scope="col" class="lg-4">Actual Effort</th>
                            </tr>
                        </thead>
                        <thead>
                            @if(optional($user)->activeProjectTeamMembers == null || optional($user)->activeProjectTeamMembers->isEmpty())
                                <div class="fz-lg-28 text-center mt-2">
                                    <div class="mb-4">Not in any project</div>
                                </div>
                            @else
                                @foreach($user->activeProjectTeamMembers as $activeProjectTeamMember)
                                    @if($activeProjectTeamMember->project->status == 'active')
                                        <tr>
                                            <td class="c-pointer">
                                                <div class="ml-2">
                                                    <a href={{ route('project.show', $activeProjectTeamMember->project) }}>
                                                        {{$activeProjectTeamMember->project->name}}
                                                        @if($activeProjectTeamMember->project->is_amc)
                                                            <div class="badge badge-pill badge-success mr-1 mt-1">AMC</div>
                                                        @endif
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (Carbon\Carbon::parse($activeProjectTeamMember->project->client->month_start_date)->format('dS M')) }}
                                                    - {{ (Carbon\Carbon::parse($activeProjectTeamMember->project->client->month_end_date)->format('dS M')) }} / {{ count($activeProjectTeamMember->project->getWorkingDaysList($activeProjectTeamMember->project->client->month_start_date, $activeProjectTeamMember->project->client->month_end_date)) }} days
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    {{ $activeProjectTeamMember->daily_expected_effort * count($activeProjectTeamMember->project->getWorkingDaysList($activeProjectTeamMember->project->client->month_start_date, $activeProjectTeamMember->project->client->month_end_date)) }} hrs
                                                    / {{ count($activeProjectTeamMember->project->getWorkingDaysList($activeProjectTeamMember->project->client->month_start_date, $activeProjectTeamMember->project->client->month_end_date)) }} days
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    {{ $activeProjectTeamMember->daily_expected_effort * count($activeProjectTeamMember->project->getWorkingDaysList($activeProjectTeamMember->project->client->month_start_date, today()->subDay())) }} hrs
                                                    / {{ count($activeProjectTeamMember->project->getWorkingDaysList($activeProjectTeamMember->project->client->month_start_date, today()->subDay())) }} days
                                                </div>
                                            </td>

                                            <td>
                                                <div class="{{ $activeProjectTeamMember->project->getbillableEffortOfTeamMember($activeProjectTeamMember->id) >= ($activeProjectTeamMember->daily_expected_effort * count($activeProjectTeamMember->project->getWorkingDaysList($activeProjectTeamMember->project->client->month_start_date, today()->subDay()))) ? 'text-success' : 'text-danger' }}"> {{ $activeProjectTeamMember->project->getbillableEffortOfTeamMember($activeProjectTeamMember->id) }}</div>
                                            </td>

                                            <td>
                                                <div>
                                                    <div>{{$activeProjectTeamMember->project->getactualEffortOfTeamMember($activeProjectTeamMember->id)}}</div>
                                                </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </thead>
                    </table>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
