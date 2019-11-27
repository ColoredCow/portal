@extends('layouts.app')

@section('content')
<div class="container" id="project_container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    <br><br>
    <h1>Create timesheet</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ route('project.timesheet.store', $project) }}" method="POST" id="form_project">

            {{ csrf_field() }}

            <div class="card-header">
                <span>Project timesheet Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Start date</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Start date" required="required" value="{{ old('name') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="client_id" class="field-required">End Date</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="End Date" required="required" value="{{ old('name') }}">
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="client_project_id" >Estimated hours</label>
                        <input type="number" class="form-control" name="client_project_id" id="client_project_id" placeholder="Estimated hours" value="{{ old('client_project_id') }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
