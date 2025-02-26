@extends('layouts.app')

@section('content')
<div class="container" id="project_container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    @include('status', ['errors' => $errors->all()])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>View Project</h1></div>
    </div>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <div class="card-header">
            <span>Project Details</span>
        </div>
        <project-details-component
            :project="{{$project}}"
            :clients="{{$clients}}"
            :employees="{{$employees}}"
        ></project-details-component>

    </div>
</div>
@endsection
