@extends('layouts.app')

@section('content')
<div class="container" id="project_container">
    <br>
    @include('finance.menu', ['active' => 'projects'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Edit Project</h1></div>
        <div class="col-md-6"><a href="{{ route('projects.create') }}" class="btn btn-success float-right">Create Project</a></div>
    </div>


    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ route('projects.update', $project->id) }}" method="POST">

            {{ csrf_field() }}
            {{ method_field('PUT') }}

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
                        <label for="invoice_email">Email for invoice</label>
                        <input type="email" class="form-control" name="invoice_email" id="invoice_email" placeholder="Email for invoice" value="{{ $project->invoice_email }}">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
    @if (sizeof($project->stages))
        <h2 class="mt-5">Project Stages</h2>
        @foreach ($project->stages as $stage)
            <project-stage-component
            :stage="{{ json_encode($stage) }}"
            :configs="{{ json_encode([
                'currencies' => config('constants.currency'),
                'projectTypes' => config('constants.project.type'),
                'gst' => config('constants.finance.gst'),
                'invoiceStatus' => config('constants.finance.invoice.status'),
                'chequeStatus' => config('constants.cheque_status'),
                'paymentTypes' => config('constants.payment_types'),
                'countries' => config('constants.countries')
            ]) }}"
            :client="{{ json_encode($project->client) }}"
            :csrf-token="{{ json_encode(csrf_token()) }}"
            :project-id="{{ $project->id }}"
            :stage-route="{{json_encode( route('project.stage'))}}"
            ref="projectStage">
            </project-stage-component>
        @endforeach
    @endif
    <project-stage-component
    v-show="newStage"
    :stage="[]"
    :stage-route="{{json_encode( route('project.stage'))}}"
    :csrf-token="{{ json_encode(csrf_token()) }}"
    :project-id="{{ $project->id }}"
    :client="{{ json_encode($project->client) }}"
    :configs="{{ json_encode([
        'currencies' => config('constants.currency'),
        'projectTypes' => config('constants.project.type'),
        'gst' => config('constants.finance.gst'),
        'invoiceStatus' => config('constants.finance.invoice.status'),
        'chequeStatus' => config('constants.cheque_status'),
        'paymentTypes' => config('constants.payment_types'),
        'countries' => config('constants.countries'),
    ]) }}"
    ></project-stage-component>

    <button class="btn btn-secondary float-right my-5" type="button" id="project_new_stage" v-show="!newStage" v-on:click="newStage = !newStage">Add new stage</button>
</div>
@endsection
