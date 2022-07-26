@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br>
    <div class="d-flex">
        <h4 class="c-pointer d-inline-block" v-on:click="counter += 1">{{ $project->name }}</h4>
        <a id="view_effort_sheet_badge" target="_self" href="{{route('project.edit', $project )}}" class="btn btn-primary text-white ml-auto">{{ _('Edit') }}</a>
    </div>
    <div class="card mt-3">
        <div class="card-header" data-toggle="collapse" data-target="#project_detail_form">
            <h4>Project details </h4>
        </div>
        <div id="project_detail_form" class="collapse show">
            <div class="card-body">
                @if($contractFilePath)
                    <div class="form-row ">
                        <div class="form-group col-md-6 pl-4 mt-2">
                            <h4 class="d-inline-block ">
                                <label for="name" class="font-weight-bold">Project Contract:</label>
                            </h4>
                            <div class="row">
                                <div class="col-xs-6 py-2">
                                    <div class="text-capitalize d-inline ml-2 fz-lg-20"> {{pathinfo($contractFilePath)['filename']}} </div>
                                    <a href="{{route('pdf.show', ['contract' => $contract])}}" target="_blank" class="btn btn-sm btn-primary text-white ml-4">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                @endif
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4 mb-0">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mt-3">Name:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->name }}</span>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5 mt-3">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Current Velocity:</label>
                        </h4>
                        <span class="{{ $project->velocity >= 1 ? 'text-success' : 'text-danger'}} fz-lg-22">{{ $project->velocity }}</span>
                        <a target="_self" href="{{route('project.effort-tracking', $project )}}" class="btn-sm text-decoration-none btn-primary text-white ml-1 text-light rounded">{{ _('Check FTE') }}</a>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Client:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->client->name }}</span>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Status:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->status }}</span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Effortsheet:</label>
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
                            <label for="name" class="font-weight-bold">Project Type:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->type }}</span>
                    </div>  
                </div>
                <br>
                <div class="form-row"> 
                    @if($project->billing_level)
                        <div class="form-group offset-md-1 pl-4 col-md-5">
                            <h4 class="d-inline-block">
                                <label for="name" class="font-weight-bold">Billing Level:</label>
                            </h4>
                            <span class="text-capitalize ml-2 fz-lg-22">{{ config('project.meta_keys.billing_level.value.' . $project->billing_level . '.label') }}</span>
                        </div>
                    @endif
                </div>
                <br>
                <div class="form-row ">
                    <div class="form-group col-lg-12 pl-4">
                        <h4 class="d-inline-block ">
                            <label for="name" class="font-weight-bold">Team Members:</label>
                        </h4>
                        <div class="fz-14 float-right mr-3 mt-1">{{ config('project.meta_keys.last_updated_at.value') . __(': ') . (Carbon\Carbon::parse($project->last_updated_at)->format('D, d-m-Y, g:i a'))}}</div>
                        <div>
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
                                                <th>Velocity <span data-toggle="tooltip" data-placement="right" title="Velocity is the ratio of current hours in project and expected hours."><i class="fa fa-question-circle"></i>&nbsp;</span></th>
                                            </tr>
                                        </thead>
                                        @if($project->TeamMembers->first() == null)
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
                                                        <td>{{$teamMember->current_expected_effort }}</td>
                                                        <td class="{{ $teamMember->velocity >= 1 ? 'text-success' : 'text-danger' }}">{{$teamMember->velocity}}</td>
                                                    </tr>
                                                @endforeach
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