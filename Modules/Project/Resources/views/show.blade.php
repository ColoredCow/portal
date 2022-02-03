@extends('project::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br>
    <div class="d-flex">
        <h4 class="c-pointer d-inline-block" v-on:click="counter += 1">{{ $project->name }}</h4>
        <a id="view_effort_sheet_badge" target="_self" href="{{route('project.edit', $project )}}"
            class="btn btn-primary text-white ml-auto">{{ _('Edit') }}</a>
    </div>
    <div class="card mt-3">
        <div class="card-header" data-toggle="collapse" data-target="#project_detail_form">
            <h4>Project details</h4>
        </div>
        <div id="project_detail_form" class="collapse show">
        <form action="{{ route('project.update', $project) }}" method="POST" id="form_update_project_details">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6 pl-5 mt-3">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Name:</label>
                            <span class="text-capitalize ml-2">{{ $project->name }}</span>
                        </h4>
                    </div>
                    <div class="form-group offset-md-1 col-md-5 mt-3">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Current FTE:</label>                        
                             <span class="text-danger">{{ $project->Fte }}</span>
                             <a id="view_effort_sheet_badge" target="_self" href= "{{route('project.effort-tracking', $project )}}" class="btn btn-primary btn-sm text-white ml-2 text-light rounded">{{ _('Check FTE') }}</a>
                        </h4> 
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Project Type:</label>
                            <span class="text-capitalize ml-2">{{ $project->type }}</span>
                        </h4>    
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Status:</label>
                            <span class="text-capitalize ml-2">{{ $project->status }}</span>
                        </h4>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6 pl-5">
                        <h4 class="d-inline-block">
                            <label for="name" class="font-weight-bold">Effortsheet:</label>
                            @if($project->effort_sheet_url)
                            <a id="view_effort_sheet_badge" href= "{{ $project->effort_sheet_url }}" class="btn btn-primary btn-sm text-white ml-2 text-light" target="_blank">{{ _('Open Sheet') }}</a>
                            @else
                            <span class="ml-2">Not Available</span>
                            @endif
                        </h4>    
                    </div>
                </div>
                <br>
                <div class="form-row ">
                    <div class="form-group col-lg-12 pl-5">
                        <h4 class="d-inline-block ">
                            <label for="name" class="font-weight-bold">Team Members:</label>
                            <div class="row gy-5">
                                @foreach($project->teamMembers ?:[] as $teamMember)
                                <div class="col-xs-6 py-2"><div class="text-capitalize pl-8 pr-5">{{$project->name}} - {{ config('project.designation')[$teamMember->pivot->designation] }}</div></div>
                                <!-- <div class="col-xs-6 py-2"><div class="text-capitalize pl-8 pr-5">{{$project->name}} - {{ config('project.designation')[$teamMember->pivot->designation] }}</div></div>
                                <div class="col-xs-6 py-2"><div class="text-capitalize pl-8 pr-5">{{$project->name}} - {{ config('project.designation')[$teamMember->pivot->designation] }}</div></div>
                                <div class="col-xs-6 py-2"><div class="text-capitalize pl-8 pr-5">{{$project->name}} - {{ config('project.designation')[$teamMember->pivot->designation] }}</div></div>
                                <div class="col-xs-6 py-2"><div class="text-capitalize pl-8 pr-5">{{$project->name}} - {{ config('project.designation')[$teamMember->pivot->designation] }}</div></div>
                                <div class="col-xs-6 py-2"><div class="text-capitalize pl-8 pr-5">{{$project->name}} - {{ config('project.designation')[$teamMember->pivot->designation] }}</div></div> -->
                                @endforeach 
                            </div> 
                        </h4>    
                    </div>
                </div>
           </div>       
        </form>            
    </div>    
</div>

@endsection