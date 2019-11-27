@extends('layouts.app')

@section('content')
<div class="container" id="project_container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    @include('status', ['errors' => $errors->all()])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>View Project</h1></div>
        <div class="col-md-6">
            <a href="{{ route('project.generate-invoice', $project) }}" class="btn btn-info float-right">Generate Invoice</a>
        </div>
    </div>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Project Details</span>
            <a href="{{ route('project.timesheet', $project) }}" class="btn btn-info c-pointer">TimeSheets</a>
        </div>

        <project-details-component
            :project="{{ $project }}"
            :clients="{{$clients}}"
            :employees="{{$employees}}"
        ></project-details-component>

    </div>
</div>
@endsection
