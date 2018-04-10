@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Edit Project</h1>
    <br>
    <a class="btn btn-info" href="/projects">See all projects</a>
    <br><br>
    @include('errors', ['errors' => $errors->all()])
    <br>
    <div class="card">
        <form action="/projects/{{ $project->id }}" method="POST">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="card-header">
                <span>Project Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name" class="field-required">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required="required" value="{{ $project->name }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="client_id" class="field-required">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required="required">
                            @foreach ($clients as $client)
                                @php
                                    $selected = $client->id === $project->client_id ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $client->id }}" {{ $selected }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="client_project_id" class="field-required">Project ID</label>
                        <input type="text" class="form-control" name="client_project_id" id="client_project_id" placeholder="Project ID" required="required" value="{{ $project->client_project_id }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="name" class="field-required">Status</label>
                        <select name="status" id="status" class="form-control" required="required">
                        @foreach (config('constants.project.status') as $status => $display_name)
                            @php
                                $selected = $status === $project->status ? 'selected="selected"' : '';
                            @endphp
                            <option value="{{ $status }}" {{ $selected }}>{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="started_on">Started on</label>
                        <input type="text" class="form-control date-field" name="started_on" id="started_on" placeholder="dd/mm/yyyy" value="{{ date(config('constants.display_date_format'), strtotime($project->started_on)) }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="invoice_email">Email for invoice</label>
                        <input type="email" class="form-control" name="invoice_email" id="invoice_email" placeholder="Email for invoice" value="{{ $project->invoice_email }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name">Type</label>
                        <select name="type" id="type" class="form-control" required="required">
                        @foreach (config('constants.project.type') as $type => $display_name)
                            @php
                                $selected = $type === $project->type ? 'selected="selected"' : '';
                            @endphp
                            <option value="{{ $type }}" {{ $selected }}>{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-3 d-flex align-items-center">
                        <input type="checkbox" name="gst_applicable" id="gst_applicable" {{ $project->gst_applicable ? 'checked="checked"' : '' }}>
                        <label for="sent_amount" class="mb-0 pl-2">Is GST applicable?</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            <span>Project Stages</span>
        </div>
        <div class="card-body">
        @foreach ($project->stages as $stage)
            <form action="/project/stages/{{ $stage->id }}" method="POST">

                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="card mt-4">
                    <div class="card-header">
                        Stage: {{ $stage->name }}
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="name" class="field-required">Stage name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Stage name" required="required" value="{{ $stage->name }}">
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="sent_amount">Stage cost</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select name="currency_cost" id="currency_cost" class="btn btn-secondary" required="required">
                                        @foreach (config('constants.currency') as $currency => $currencyMeta)
                                            @php
                                                $selected = $currency === $stage->currency_cost ? 'selected="selected"' : '';
                                            @endphp
                                            <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <input type="number" class="form-control" name="cost" id="cost" placeholder="Stage cost" step=".01" min="0" value="{{ $stage->cost }}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-3 d-flex align-items-center">
                                <input type="checkbox" name="cost_include_gst" id="cost_include_gst" {{ $stage->cost_include_gst ? 'checked="checked"' : '' }}>
                                <label for="sent_amount" class="mb-0 pl-2">Is GST included in Stage Cost?</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update stage</button>
                    </div>
                </div>
            </form>
        @endforeach
        </div>
    </div>
</div>
@endsection
