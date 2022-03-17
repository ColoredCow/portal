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
                <div class="form-row ">
                    <div class="form-group col-md-6 pl-4 mt-2">
                        <h4 class="d-inline-block ">
                            <label for="name" class="font-weight-bold">Project Contract:</label>
                        </h4>
                        <div class="row gy-5">
                            <div class="col-xs-6 py-2">
                                <div class="text-capitalize d-inline ml-2 fz-lg-22"> {{$contractFileName}} </div>
                                <a href="{{route('pdf.show', ['contractFileName' => $contractFileName])}}" target="_blank" class="btn btn-primary text-white ml-4">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="mb-5">
        @include('project::subviews.show-project-hours')
    </div>
</div>

@endsection