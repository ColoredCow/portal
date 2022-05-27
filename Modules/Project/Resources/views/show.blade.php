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
                        <div class="form-group pl-4 mt-2">
                            <h4 class="d-inline-block ">
                                <label for="name" class="font-weight-bold">Project Contract:</label>
                                <span class="text-capitalize d-inline ml-2 fz-lg-20"> {{pathinfo($contractFilePath)['filename']}} </span>
                                <a href="{{route('pdf.show', ['contract' => $contract])}}" target="_blank" class="btn-sm btn-primary text-white ml-2">View</a>
                            </h4>
                        </div>
                    </div>
                @endif
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold mt-2">Name:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->name }}</span>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5 mt-2">
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
                            <label for="name" class="font-weight-bold">Project Type:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->type }}</span>
                    </div>
                    <div class="form-group offset-md-1 col-md-5 pl-4">
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
                <div class="form-row">
                    <div class="form-group pl-4 col-md-6">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Monthly Expected Hours:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->expected_monthly_hours }}</span>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Current Expected Hours:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->current_expected_hours }}</span>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-4">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Current Hours:</label>
                        </h4>
                        <span class="text-capitalize ml-2 fz-lg-22">{{ $project->current_hours_for_month }}</span>
                    </div>
                    <div class="form-group offset-md-1 pl-4 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Project FTE:</label>
                        </h4>
                        <span class="{{ $project->fte >= 1 ? 'text-success' : 'text-danger'}} fz-lg-22">{{ $project->fte }}</span>
                        <a target="_self" href="{{route('project.effort-tracking', $project )}}" class="{{ $project->fte >= 1 ? 'text-success' : 'text-danger' }} ml-1 rounded"><i class="mr-0.5 c-pointer fa fa-external-link-square"></i></a>
                    </div>
                </div>
                <br>
                <div class="form-row px-md-2">
                    <div class="bg-theme-gray-lightest rounded form-group col-lg-12 pl-4 py-2">
                        <h4 class="d-inline-block ">
                            <label for="name" class="font-weight-bold">Team Members:</label>
                        </h4>
                        <div class="font-weight-bold text-secondary d-flex">
                            <div class="w-30p pl-3">
                                {{ __('Name') }}
                            </div>
                            <div class="w-25p">
                                {{ __('Expected Effort') }}
                            </div>
                            <div class="w-25p">
                                {{ __('Current Effort') }}
                            </div>
                            <div class="w-25p">
                                {{ __('FTE') }}
                            </div>
                        </div>
                        <hr class="border mx-2">
                        @forelse($project->getTeamMembers ?:[] as $teamMember)
                        <div class="mb-2 d-flex align-items-center">
                            <div class="w-30p">
                                <span class="ml-1 tooltip-wrapper" data-html="true" data-toggle="tooltip" title="{{ $teamMember->user->name }} - {{ config('project.designation')[$teamMember->designation] }}">
                                    <img src="{{ $teamMember->user->avatar }}" class="w-40 h-40 rounded-circle mr-1 mb-1">
                                </span>
                                <span class="font-weight-bold">
                                    {{ $teamMember->user->name }}
                                </span>
                            </div>
                            <div class="w-25p font-weight-bold">
                                {{ $teamMember->current_expected_effort }}
                            </div>
                            <div class="w-25p font-weight-bold">
                                {{ $teamMember->current_actual_effort }}
                            </div>
                            <div class="w-25p font-weight-bold {{ $teamMember->current_fte < 1 ? 'text-danger' : 'text-success' }}">
                                {{ $teamMember->current_fte }}
                            </div>
                        </div>
                        <hr class="border mx-2">    
                        @empty
                        <div class="text-center my-5">
                            <span class="font-weight-bold">{{ __('No Team Members') }}</span>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection