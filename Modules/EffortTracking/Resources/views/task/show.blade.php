@extends('efforttracking::layouts.master')

@section('content')
<div class="container containermodified">
    <h1>{{$project->name}}</h1>
    <div class="mt-4 card">
        <div class="card-header">
            Project Details
        </div>
        <div class="card-body">
            <div class="row">
                <!-- try to add client name from client module -->
                <h5 class="col-md-5">Client Name - _</h5>
                <h5 class="col-md-5">Status - {{$project->status}}</h5>
            </div>

            <div class="mt-4 row">
                <div class="col-md-5">
                    <h5>Start Date - {{$project->start_date}}</h5>
                </div>
                <div class="col-md-5">
                    <h5>End Date - {{$project->end_date}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div>

    <h4 class="mt-4">Task Details</h4>
    <div class="ml-5 mt-2 row">
                <div class="col-md-2 col-lg-2 col-sm-2">
                    <label for="name" class="field-required">Name</label>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2">
                    <label for="name" class="field-required">Worked On</label>
                </div>
                <div class="col-md-1 col-lg-1 col-sm-1">
                    <label for="name" class="field-required">Type</label>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2">
                    <label for="name" class="field-required">Asignee</label>
                </div>
                <div class="col-md-1 col-lg-1 col-sm-1">
                    <label for="name" class="field-required">Estimated Effort</label>
                </div>
                <div class="col-md-1 col-lg-1 col-sm-1">
                    <label for="name" class="field-required">Effort Spent</label>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-2">
                    <label for="name" class="field-required">Action</label>
                </div>
    </div>
    <div>
        <div class="d-none" id="add_form">
            @include('efforttracking::task.update-task',['task'=>$addTask])
        </div>
            <div  id="update_task_form_list">
                @foreach($tasks as $task)
                        @include('efforttracking::task.update-task',['task'=>$task])
                @endforeach
            </div>

            <div id="add_task_form_list">
                <!-- Will dynamically append the form whenever the add add new task button is clicked -->
            </div>
        <button type="button" class="btn btn-outline-primary" id="add_task"><i class="fa fa-plus"></i> Add new task</button>
    </div>

</div>
@endsection
