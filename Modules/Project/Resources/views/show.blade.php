@extends('project::layouts.master')
@section('content')
<div class="container" id="vueContainer">
    <br>
    <div class=" d-flex">
        <h4 class="c-pointer d-inline-block font-weight-bold" v-on:click="counter += 1">Project Name : {{$project->name}}</h4>
        @can('update', $project)
            <a id="view_effort_sheet_badge" target="_self" href="{{route('project.edit', $project )}}" class="btn btn-primary text-white ml-auto">{{ _('Edit') }}</a>
        @endcan
    </div>
    <br>
    <div class="card-header d-flex" data-toggle="collapse" data-target="#resource-engagement" >
        <h4>Resource Engagement</h4>
        <span class ="arrow ml-auto rotate180">&#9660;</span>
    </div>
    <div id="resource-engagement" class= "collapse card mt-3 show">
        <div class="collapes-body">
            <br>
            <div class="container" id="vueContainer">
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mb-1">Current Velocity:</label>
                        </h4>
                        <span class="{{ $project->velocity >= 1 ? 'text-success' : 'text-danger'}} fz-lg-22">{{ $project->velocity }}</span>
                        {{-- <a target="_self" href="{{route('project.effort-tracking', $project )}}" class="btn-sm text-decoration-none btn-primary text-white ml-1 text-light rounded">{{ _('Check FTE') }}</a> --}}
                    </div>
                    <div class="form-group col-md-6 pl-10">
                            <h4 class="d-inline-block">
                                <label for="name" class="font-weight-bold mb-6 ml-1">Effortsheet:</label>
                            </h4>
                            @if($project->effort_sheet_url)
                                <a id="view_effort_sheet_badge" href="{{ $project->effort_sheet_url }}" class="btn-sm btn-primary btn-smtext-white ml-2 text-light rounded"
                                    target="_blank">{{ _('Open Sheet') }}</a>
                            @else
                                <span class="ml-2 fz-lg-22">Not Available</span>
                            @endif
                    </div>
                </div>                  
                <div class="form-row">
                    <div class="form-group col-lg-12 pl-4">
                        <div class="fz-14 mr-3 mt-1 d-flex justify-content-between">
                            <h4 class="d-inline-block ">
                                <label for="name" class="font-weight-bold">Team Members({{count($project->getTeamMembers)}})</label>
                            </h4>
                        <div class="d-flex">
                            <h4 class="mr-5">
                                <i class="fa fa-spinner fa-spin ml-2 d-none"></i>
                                <i class="ml-2 font-weight-bold fa fa-refresh c-pointer" aria-hidden="true"
                                data-url="{{ route('effort-tracking.refresh', $project) }}"></i>
                            </h4>
                                <strong>Timeline:</strong>{{ (Carbon\Carbon::parse($project->client->month_start_date)->format('dS M')) }}
                                -{{ (Carbon\Carbon::parse($project->client->month_end_date)->format('dS M')) }}
                                &nbsp;&nbsp;&nbsp; <strong>Last refreshed at:</strong>{{ (Carbon\Carbon::parse($project->last_updated_at)->setTimezone('Asia/Kolkata')->format('Y-M-d , D h:i:s A')) }}
                        </div>
                        </div>
                            <div class="flex-column flex-md-row d-flex flex-wrap col-md-18 px-0 ml-1 mr-4">
                                <div class="table">
                                    <table class="table">
                                        <thead>
                                            <tr class="bg-theme-gray text-light">
                                                <th class="pb-md-3 pb-xl-4 px-9">Name</th>
                                                <th>Expected Billable <br>hrs/WD
                                                    {{-- <div class="ml-lg-3 ml-xl-5 fz-md-10 fz-xl-14">
                                                        ({{$daysTillToday}} Days)
                                                    </div> --}}
                                                </th>
                                                <th>Working Days <br>Total | Completed</th>
                                                <th>Total Efforts Booked 
                                                    {{-- <br>Billable | Actual</th> --}}
                                                {{-- <th>Velocity <span data-toggle="tooltip" data-placement="right" title="Velocity is the ratio of current hours in project and expected hours."><i class="fa fa-question-circle"></i>&nbsp;</span></th> --}}
                                            </tr>
                                        </thead>
                                        @if($project->teamMembers->first() == null)
                                            </table>
                                            <div class="fz-lg-28 text-center mt-4">No member in the project</div>
                                        @else
                                            <tbody>
                                            @foreach($project->getTeamMembers  as $teamMember)
                                                <tr>
                                                    <th class="fz-lg-20 my-2 px-5 font-weight-normal">
                                                        <span>
                                                            <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="{{ $teamMember->user->name }} - {{ config('project.designation')[$teamMember->designation] }}">
                                                            <a href="{{ route('employees.show', $teamMember->user->employee->id) }}"> 
                                                            <img src="{{ $teamMember->user->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">
                                                            </a>
                                                        </span>
                                                        <a href="{{ route('employees.show', $teamMember->user->employee->id) }}"> 
                                                        {{$teamMember->user->name}} 
                                                        </a>
                                                    </th>
                                                    <td id="projectHours">{{$teamMember->daily_expected_effort }}</td>
                                                    <td data-toggle="tooltip" title="Start date: {{$teamMember->started_on->format('Y-m-d')}}  {{$teamMember->ended_on != null ? "End date: " . ($teamMember->ended_on->format('Y-m-d')) : ""}}">{{$effortData['totalWorkingDays']}} Days | {{$effortData['daysTillToday']}} Days</td>
                                                    <td>{{$teamMember->current_actual_effort}}hrs
                                                        {{-- | {{$project->getactualEffortOfTeamMember([$teamMember->id])}}hrs</td> --}}
                                                    {{-- <td class="{{ $teamMember->velocity >= 1 ? 'text-success' : 'text-danger' }}">{{$teamMember->velocity}}</td> --}}
                                                </tr>
                                            @endforeach

                                            </tbody>
                                            </table>
                                        @endif
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="px-4">
                        <h1 class="font-weight-bold fz-22">Team Member Engagement Stats</h1>
                        <form action="{{ route('project.show', $project) }}" id="FilterForm" method="GET">
                            <div class="d-flex">
                                <div class='form-group mr-4 ml-1 mt-1 w-168'>
                                    <select class="form-control bg-light" name="month"
                                            onchange="document.getElementById('FilterForm').submit();">
                                        @foreach (config('constants.months') as $months => $month)
                                            <option value="{{ $month }}" {{ $effortData['currentMonth'] == $month ? 'selected' : '' }}>
                                                {{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                
                                <div class='form-group mr-4 mt-1 w-168'>
                                    <select class="form-control bg-light" name="year"
                                        onchange="document.getElementById('FilterForm').submit();">
                                        @php $year = now()->year; @endphp
                                        @while ($year != 1999)
                                            <option {{ request()->input('year') == $year ? 'selected=selected' : '' }}
                                                value="{{ $year }}">
                                                {{ $year-- }}
                                            </option>
                                        @endwhile
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div>
                                <div class="mt-4">
                                    <input type="hidden" name="team_members_effort" value="{{ $effortData['teamMembersEffort'] }}">
                                    <input type="hidden" name="workingDays" value="{{ $effortData['workingDaysObject'] }}">
                                    <input type="hidden" name="totalWorkingDays" value="{{ $effortData['totalWorkingDays'] }}">
                                    <input type="hidden" name="users" value="{{ $effortData['users'] }}">
                                    <input type="hidden" name="dailyEffort" value="{{ $dailyEffort }}">
                                    <canvas class="w-full" id="effortTrackingGraph"></canvas>
                                </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    <br>
    <div class="card-header d-flex" data-toggle="collapse" data-target="#approved-pipeline">
        <h4>Approved Pipeline</h4>
        <span class ="arrow ml-auto">&#9660;</span>
    </div>
    <div id="approved-pipeline" class="collapse card mt-3">
        <div class="panel-body">
            <br>
                <div class="form-row">
                        <div class="form-row d-flex justify-content-between">
                            <div class="col-md-5 pl-4 d-flex justify-content-between">
                                <div class="mr-5">
                                    <h4 class="d-inline-block">
                                        <label for="name" class="font-weight-bold mb-6 ml-1">Expected Hours:</label>
                                    </h4>
                                </div>
                                <div class="d-flex">
                                    <div class="pr-10 project-hour text-center">
                                        <span class="fz-lg-22 text-capitalize">Monthly
                                        </span>
                                        <span>{{$totalExpectedHourInMonth}}</span>
                                    </div>
                                    <div class="d-flex">
                                        <div class="pr-10 project-hour text-center">
                                            <span class="fz-lg-22 text-capitalize">Weekly
                                            </span>
                                            <span>{{$totalWeeklyEffort}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                    <div class="form-row">
                        <div class="form-row d-flex justify-content-between">
                            <div class="col-md-5 pl-4 d-flex justify-content-between">
                                <div class="mr-5">
                                    <h4 class="d-inline-block">
                                        <label for="name" class="font-weight-bold mb-6 ml-1">Hours To Cover:</label>
                                    </h4>
                                </div>
                                <div class="d-flex">
                                    <div class="pr-10 project-hour text-center">
                                        <span class="fz-lg-22 text-capitalize">Monthly
                                        </span>
                                        <span>{{$remainingExpectedEffort}}</span>
                                    </div>
                                    <div class="d-flex">
                                        <div class="pr-10 project-hour text-center">
                                            <span class="fz-lg-22 text-capitalize">Weekly
                                            </span>
                                            <span>{{round($weeklyHoursToCover,2)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-5 pl-4 d-flex justify-content-between">
                            <h4 class="d-inline-block">
                                <label for="name" class="font-weight-bold mb-6 ml-1">Approved Pipeline:</label>
                                @if ($isApprovedWorkPipelineExist)
                                <span>{{$monthlyApprovedHour}} hrs
                                    @if($monthlyApprovedHour > $weeklyHoursToCover)
                                    <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Approved pipeline is sufficient for this week"><i class="fa fa-info-circle" style="color: green;" aria-hidden="true"></i></span>
                                    @else
                                    <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Approved pipeline is not sufficient for this week"><i class="fa fa-info-circle" style='color: red' aria-hidden="true"></i></span>
                                    @endif
                                </span>
                                @else
                                    <span class="text-capitalize ml-2 text-danger fz-18 font-weight-normal">
                                        ERROR <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Formatting issue with effortsheet"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                    </span>
                                @endif
                            </h4>
                        </div>
                    </div>
            </div>
    </div>
    <br>
    <div class="card-header d-flex" data-toggle="collapse" data-target="#basic-details" >
        <h4>Basic Details</h4>
        <span class ="arrow ml-auto">&#9660;</span>
    </div>

    <div id="basic-details" class="collapse card mt-3">
       <div class="m-5"> 
        <div class="d-flex" style="flex-wrap: wrap">
            <div class="pr-10 project-hour w-33p mb-10">
                <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold">Start Date:</label>
                </h4>
                <span class="text-capitalize  fz-lg-22">{{ optional($project->start_date)->format('d M Y')}}</span>
            </div>
                <div class="pr-10 project-hour w-33p mb-10">
                    <h4 class="d-inline-block">
                    <label for="name" class="font-weight-bold ">End Date:</label>
                    </h4>
                    <span class="text-capitalize  fz-lg-22">{{ optional($project->end_date)->format('d M Y')}}</span>
                </div>
                <div class="pr-10 project-hour w-33p mb-10">
                    <h4 class="d-inline-block">
                        <label for="name" class="font-weight-bold ">Project Name:</label>
                    </h4>
                    <span class="text-capitalize  fz-lg-22">{{ $project->name }}</span>
                    @if ($project->is_amc == 1 )
                    <span class="badge badge-pill badge-success mr-1  mt-1">AMC</span>
                    @endif
                </div>
                <div class="pr-10 project-hour w-33p mb-10">
                    <h4 class="d-inline-block">
                        <label for="name" class="font-weight-bold">Client Name:</label>
                    </h4>
                    <a href="{{route('client.edit', $project->client->id)}}" class="text-capitalize fz-lg-22">{{ $project->client->name }}</a>
                </div>
                    <div class="pr-10 project-hour w-33p mb-10">
                        <h4 class="d-inline-block">
                        <label for="name" class="font-weight-bold ">Status:</label>
                        </h4>
                        <span class="text-capitalize fz-lg-22">{{ $project->status }}</span>
                    </div>
                    <div class="pr-10 project-hour w-33p mb-10">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold ">Project Type:</label>
                        </h4>
                        <span class="text-capitalize fz-lg-22">{{ $project->type }}</span>
                    </div>
                    <div class="pr-10 project-hour w-33p mb-10">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold ">Contract File:</label>
                        </h4>
                        <div class="flex-row">
                            @if ($project->projectContracts->isEmpty() == false)
                            <a id="contract_file"
                            style="{{ $project->projectContracts ? '' : 'd-none' }}"
                            href="{{ route('pdf.show', $project->projectContracts->first()) }}">
                             <span class="text-capitalize fz-lg-22">{{ $project->name}}_contract_{{ optional($project->projectContracts->first()->updated_at)->format('d-m-y') }}</span>
                             <i class="fa fa-external-link-square fa-1x"></i></a>
                            @endif
                    </div>
        </div>
       </div>
    </div>
</div>
@endsection

