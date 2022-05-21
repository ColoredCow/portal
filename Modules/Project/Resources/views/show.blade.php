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
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mt-3">Name:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->name }}</span>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5 mt-3">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Current FTE:</label>
                        </h4>
                        <span class="{{ $project->fte >= 1 ? 'text-success' : 'text-danger'}} fz-lg-22">{{ $project->fte }}</span>
                        <a target="_self" href="{{route('project.effort-tracking', $project )}}" class="btn-sm text-decoration-none btn-primary text-white ml-1 text-light rounded">{{ _('Check FTE') }}</a>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Project Type:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->type }}</span>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Status:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->status }}</span>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Effortsheet:</label>
                        </h4>
                        @if($project->effort_sheet_url)
                        <a id="view_effort_sheet_badge" href="{{ $project->effort_sheet_url }}" class="btn btn-primary btn-sm text-white ml-2 text-light rounded" target="_blank">{{ _('Open Sheet') }}</a>
                        @else
                        <span class="ml-2 fz-lg-22">Not Available</span>
                        @endif
                    </div>
                </div>
                <br>
                <div class="form-row ">
                    <div class="form-group col-lg-12 pl-4">
                        <h4 class="d-inline-block ">
                            <label for="name" class="font-weight-bold">Team Members:</label>
                        </h4>
                        <div>
                            <div class="flex-column flex-md-row d-flex flex-wrap col-12 px-0 ml-3">
                                @foreach($project->teamMembers ?:[] as $teamMember)
                                    <div class="fz-lg-22 my-2 px-0 col-6">
                                        <span>
                                            <img src="{{ $teamMember->avatar }}" class="w-35 h-30 rounded-circle mr-1 mb-1">
                                        </span>
                                        {{$teamMember->name}} - {{ config('project.designation')[$teamMember->pivot->designation] }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection