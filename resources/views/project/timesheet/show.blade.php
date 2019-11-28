@extends('layouts.app')

@section('content')
<div class="container" id="project_timesheet_container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    @include('status', ['errors' => $errors->all()])
    <br><br>
    <div class="row">
        <div class="col-md-6">
            <h1>Timesheet</h1>
            <h2>{{ $timesheet->start_date->format('d-M-Y') }} - {{ $timesheet->end_date->format('d-M-Y') }}</h2>
        </div>
        <div class="col-md-6">
            <a href="" class="btn btn-success float-right">Generate Invoice</a>
        </div>
    </div>
    <div>
        <timesheet-component
            :timesheet = "{{ $timesheet }}"
            :project = "{{ $project }}"
            :subtasks = "{{ json_encode(config('constants.project.timesheet.module.subtasks')) }}"
            :project-statuses = "{{ json_encode(config('constants.project.timesheet.module.status')) }}"
            ></timesheet-component>
    </div>
    @include('status', ['errors' => $errors->all()])
</div>
@endsection
