@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br>
    <div class="d-flex">
        <h4 class="c-pointer d-inline-block">{{ $project->name }}</h4>
        <a id="view_effort_sheet_badge" target="_self" href="{{route('project.edit', $project )}}" class="btn btn-primary text-white ml-auto">{{ _('Edit') }}</a>
    </div>
    <div class="card mt-3">
        <div class="card-header" data-toggle="collapse" data-target="#project_detail_form">
            <h4>Project details</h4>
        </div>
        <div id="project_detail_form" class="collapse show">
            <div class="card-body">
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
                        <span class="text-danger fz-lg-22">{{ $project->Fte }}</span>
                        <a id="view_effort_sheet_badge" target="_self" href="{{route('project.effort-tracking', $project )}}" class="btn btn-primary btn-sm text-white ml-2 text-light rounded">{{ _('Check FTE') }}</a>
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
                        <div class="row gy-5">
                            @foreach($project->teamMembers ?:[] as $teamMember)
                            <div class="col-xs-6 py-2">
                                <div class="text-capitalize pl-8 pr-5 fz-lg-22">{{$teamMember->name}} - {{ config('project.designation')[$teamMember->pivot->designation] }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection