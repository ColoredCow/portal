@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br>
    <div class="d-flex">
        <h4 class="c-pointer d-inline-block" v-on:click="counter += 1">{{$project->name}}</h4>
        @can('update', $project)
            <a id="view_effort_sheet_badge" target="_self" href="{{route('project.edit', $project )}}" class="btn btn-primary text-white ml-auto">{{ _('Edit') }}</a>
        @endcan
    </div>
    <div class="card mt-3">
        <div class="card-header" data-toggle="collapse" data-target="#project_detail_form">
            <h4>Project details </h4>
        </div>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4 mb-0">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mb-6 mt-2 ml-1">Name:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->name }}</span>
                        @if ($project->is_amc == 1 )
                        <span class="badge badge-pill badge-success mr-1  mt-1">AMC</span>
                        @endif
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5 mt-3">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mb-1">Current Velocity:</label>
                        </h4>
                        <span class="{{ $project->velocity >= 1 ? 'text-success' : 'text-danger'}} fz-lg-22">{{ $project->velocity }}</span>
                        <a target="_self" href="{{route('project.effort-tracking', $project )}}" class="btn-sm text-decoration-none btn-primary text-white ml-1 text-light rounded">{{ _('Check FTE') }}</a>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mb-6 ml-1">Client:</label>
                        </h4>
                        <a href="{{route('client.edit', $project->client->id)}}" class="text-capitalize ml-2 fz-lg-22">{{ $project->client->name }}</a>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mb-3">Status:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->status }}</span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
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
                    <div class="form-group offset-md-1 pl-4 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mt-0 mb-2">Project Type:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->type }}</span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        @if($project->billing_level)
                            <h4 class="d-inline-block">
                                <label for="name" class="font-weight-bold mb-6 ml-1">Billing Level:</label>
                            </h4>
                            <span class="text-capitalize ml-2 fz-lg-22">{{ config('project.meta_keys.billing_level.value.' . $project->billing_level . '.label') }}</span>
                        @endif
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Total Estimated Hour:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->total_estimated_hours }}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Start Date:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ optional($project->start_date)->format('d M Y')}}</span>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Monthly Approved Pipeline:</label>
                        </h4>
                        @if ($isApprovedWorkPipelineExist)
                            <span class="text-capitalize ml-2 fz-lg-22">{{ $project->monthly_approved_pipeline }}</span>
                        @else
                            <span class="text-capitalize ml-2 text-danger fz-18">
                                ERROR <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Formatting issue with effortsheet"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group col-md-6 pl-4">
                    <h4 class="d-inline-block">
                        <label for="name" class="font-weight-bold mb-6 mr-4 mt-2">End Date:</label>
                   </h4>
                    <span class="text-capitalize ml-2 fz-lg-22">{{ optional($project->end_date)->format('d M Y')}}</span>
                </div>
                <div id= "project_detail_form" class="collapse show">
                    <div class="card-body">
                        @if($contractFilePath)
                            <div class="form-row">
                                <div class="form-group col-md-0 pl-1 ml-0 mr-5">
                                    <h4 class="d-inline-block ">
                                        <label for="name" class="font-weight-bold mb-16 ml-1">Project Contract:</label>
                                    </h4>
                                        <div class="text-capitalize d-inline ml-2 fz-lg-22 "> {{pathinfo($contractFilePath)['filename']}} </div>
                                        <a href="{{route('pdf.show', ['contract' => $contract])}}" target="_blank" class="btn btn-sm btn-primary text-white ml-4">View</a>
                                    </div>
                                 </div>
                            </div>
                @endif
                <br>
                <div class="form-row ">
                    <div class="form-group col-lg-12 pl-4">
                        <h4 class="d-inline-block ">
                            <label for="name" class="font-weight-bold">Team Members({{count($project->getTeamMembers)}})</label>
                        </h4>
                       <div class="fz-14 float-right mr-3 mt-1">
                            <strong>Timeline:</strong>{{ (Carbon\Carbon::parse($project->client->month_start_date)->format('dS M')) }}
                            -{{ (Carbon\Carbon::parse($project->client->month_end_date)->format('dS M')) }}
                             &nbsp;&nbsp;&nbsp; <strong>Last refreshed at:</strong>{{ (Carbon\Carbon::parse($project->last_updated_at)->setTimezone('Asia/Kolkata')->format('Y-M-d , D h:i:s A')) }}
                        </div>
                            <div class="flex-column flex-md-row d-flex flex-wrap col-md-18 px-0 ml-1 mr-4">
                                <div class="table">
                                    <table class="table">
                                        <thead>
                                            <tr class="bg-theme-gray text-light">
                                                <th class="pb-md-3 pb-xl-4 px-9">Name</th>
                                                <th>Hours Booked</th>
                                                <th>Expected Hours
                                                    <div class="ml-lg-3 ml-xl-5 fz-md-10 fz-xl-14">
                                                        ({{$daysTillToday}} Days)
                                                    </div>
                                                </th>
                                                <th> Test
                                                
                                                </th>
                                                <th>Velocity <span data-toggle="tooltip" data-placement="right" title="Velocity is the ratio of current hours in project and expected hours."><i class="fa fa-question-circle"></i>&nbsp;</span></th>
                                            </tr>
                                        </thead>
                                        @if($project->teamMembers->first() == null)
                                            </table>
                                            <div class="fz-lg-28 text-center mt-4">No member in the project</div>
                                        @else
                                            <tbody>
                                                @foreach($project->getTeamMembers ?:[] as $teamMember)
                                                    <tr>
                                                        <th class="fz-lg-20 my-2 px-5 font-weight-normal">
                                                            <span>
                                                                <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="{{ $teamMember->user->name }} - {{ config('project.designation')[$teamMember->designation] }}">
                                                                <img src="{{ $teamMember->user->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">
                                                            </span>
                                                            {{$teamMember->user->name}}
                                                        </th>
                                                        <td class="{{ $teamMember->current_actual_effort >= $teamMember->current_expected_effort ? 'text-success' : 'text-danger' }}">{{$teamMember->current_actual_effort}}</td>
                                                        <td>{{$teamMember->current_expected_effort }} <span data-toggle="tooltip" data-placement="right" title="Velocity is the ratio of current hours in project and expected hours."></td>
                                                        <td class="{{ $teamMember->velocity >= 1 ? 'text-success' : 'text-danger' }}">

                                                            <div
                                                                    class="d-flex border border-dark position-relative tooltip-wrapper"
                                                                    data-toggle="modal" data-target="#effortbarchart_{{$project->id}}"
                                                                >
                                                                    <span
                                                                        class="bg-success position-absolute px-2"
                                                                        style="width: calc($teamMember->total_expected_effort['totalexpectedeffort']}} / {{ $teamMember->total_expected_effort['totalactualeffort'] }}px)"
                                                                    >
                                                                    <span class="tooltip-wrapper" data-html="true" data-toggle="tooltip" title="Velocity is the" >
                                                                        {{$teamMember->total_expected_effort['totalactualeffort']}}
                                                                        </span>
                                                                    </span>
                                                                    <span class="bg-danger px-2" style="width: $teamMember->total_expected_effort['totalexpectedeffort']}}px;">{{$teamMember->total_expected_effort['totalexpectedeffort']}}</span>
                                                                </div>


                                                                <div class="modal fade" id="effortbarchart_{{$project->id}}" tabindex="-1" role="dialog" aria-labelledby="effortbarchartlable_{{$project->id}}" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="effortbarchartlable_{{$project->id}}">Modal title</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                        <table>
                                                                        
                                                                        <table class="table table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                <th scope="col">S.no</th>
                                                                                <th scope="col">Project Name</th>
                                                                                <th scope="col"></th>
                                                                                <th scope="col">Handle</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <
                                                                            @php
                                                                                    $testJson = json_encode([
                                                                                        ["label"=> "Sachin Tendulkar", "y"=> 49],
                                                                                        ["label"=> "Ricky Ponting", "y"=> 30],
                                                                                        ["label"=> "Kumar Sangakkara", "y"=> 25],
                                                                                        ["label"=> "Jacques Kallis", "y"=> 17],
                                                                                        ["label"=> "Mahela Jayawardene", "y"=> 19],
                                                                                        ["label"=> "Hashim Amla", "y"=> 26],
                                                                                        ["label"=> "Brian Lara", "y"=> 19],
                                                                                        ["label"=> "Virat Kohli", "y"=> 32],
                                                                                        ["label"=> "Rahul Dravid", "y"=> 12],
                                                                                        ["label"=> "AB de Villiers", "y"=> 25]
                                                                                    ], JSON_NUMERIC_CHECK);

                                                                                    $odiJson = json_encode([
                                                                                        ["label"=> "Sachin Tendulkar", "y"=> 49],
                                                                                        ["label"=> "Ricky Ponting", "y"=> 30],
                                                                                        ["label"=> "Kumar Sangakkara", "y"=> 25],
                                                                                        ["label"=> "Jacques Kallis", "y"=> 17],
                                                                                        ["label"=> "Mahela Jayawardene", "y"=> 19],
                                                                                        ["label"=> "Hashim Amla", "y"=> 26],
                                                                                        ["label"=> "Brian Lara", "y"=> 19],
                                                                                        ["label"=> "Virat Kohli", "y"=> 32],
                                                                                        ["label"=> "Rahul Dravid", "y"=> 12],
                                                                                        ["label"=> "AB de Villiers", "y"=> 25]
                                                                                    ], JSON_NUMERIC_CHECK);

                                                                                    $t20Json = json_encode([
                                                                                        ["label"=> "Sachin Tendulkar", "y"=> 0],
                                                                                        ["label"=> "Ricky Ponting", "y"=> 0],
                                                                                        ["label"=> "Kumar Sangakkara", "y"=> 0],
                                                                                        ["label"=> "Jacques Kallis", "y"=> 0],
                                                                                        ["label"=> "Mahela Jayawardene", "y"=> 1],
                                                                                        ["label"=> "Hashim Amla", "y"=> 0],
                                                                                        ["label"=> "Brian Lara", "y"=> 0],
                                                                                        ["label"=> "Virat Kohli", "y"=> 0],
                                                                                        ["label"=> "Rahul Dravid", "y"=> 0],
                                                                                        ["label"=> "AB de Villiers", "y"=> 0]
                                                                                    ], JSON_NUMERIC_CHECK);
                                                                                @endphp

                                                                            <div id="chartContainer"
                                                                                data-test="{{ htmlspecialchars($testJson, ENT_QUOTES, 'UTF-8') }}"
                                                                                data-odi="{{ htmlspecialchars($odiJson, ENT_QUOTES, 'UTF-8') }}"
                                                                                data-t20="{{ htmlspecialchars($t20Json, ENT_QUOTES, 'UTF-8') }}">
                                                                            </div>
                                                                                <tr>
                                                                                <th scope="row">1</th>
                                                                                <td>Mark</td>
                                                                                <td>Otto</td>
                                                                                <td>@mdo</td>
                                                                                </tr>
                                                                            </tbody>
                                                                            </table>

                                                                        </table>
                                                                        </div>
                                                                        
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </td>
                                                        <td class="{{ $teamMember->velocity >= 1 ? 'text-success' : 'text-danger' }}">{{$teamMember->velocity}}</td>
                                                    </tr>
                                                <!-- @endforeach -->
                                            </tbody>
                                            </table>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
