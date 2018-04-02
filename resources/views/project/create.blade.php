@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Create Project</h1>
    <br>
    <a class="btn btn-info" href="/projects">See all projects</a>
    <br><br>
    <div class="card">
        <form action="/projects" method="POST" id="form_project">

            {{ csrf_field() }}

            <div class="card-header">
                <span>Project Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="client_id">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required="required">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="client_project_id">Project ID</label>
                        <input type="text" class="form-control" name="client_project_id" id="client_project_id" placeholder="Project ID" required="required">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="name">Status</label>
                        <select name="status" id="status" class="form-control" required="required">
                        @foreach (config('constants.project.status') as $status => $display_name)
                            <option value="{{ $status }}">{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="started_on">Started on</label>
                        <input type="text" class="form-control date-field" name="started_on" id="started_on" placeholder="dd/mm/yyyy">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="invoice_email">Email for invoice</label>
                        <input type="email" class="form-control" name="invoice_email" id="invoice_email" placeholder="Email for invoice">
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
