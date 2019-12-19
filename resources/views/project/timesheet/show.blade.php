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
        <div class="align-items-end d-flex mt-4 row">
            <div class="col-2">
                <h4>Modules</h4>
            </div>

            <div class="col-2">
                <h4>Subtask</h4>
            </div>

            <div class="col-2">
                <h4>Status</h4>
            </div>

                <div class="col-1">
                <h4>Total</h4>
                </div>

            <div class="col-5">
                <div class="d-flex justify-content-center">
                   <h4>Month Days</h4>
                </div>
            </div>
        </div>

        @include('project.timesheet.components.module-listing')

        <button class="btn btn-primary">Add New Module</button>
    </div>
    @include('status', ['errors' => $errors->all()])
</div>
@endsection
