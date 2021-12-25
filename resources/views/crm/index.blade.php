@extends('layouts.app')

@section('content')
<div class="container">
    <h1>CRM Dashboard</h1>
    <br>
    <div class="widgetbar mb-10">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createCrmConnectionModal">Add New Connection</button>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Last connected</th>
            <th>Status</th>
            <th>Contact</th>
            <th>Source</th>
            <th>Last interaction</th>
            <th>Next steps</th>
            <th>Notes</th>
        </thead>
        <?php foreach ($data['crm_details'] as $details) : ?>
            <tbody>
                <td>{{ $details->id ?? '-' }}</td>
                <td>{{ $details->prospect_id ?? '-' }}</td>
                <td>{{ $details->last_connected ?? '-' }}</td>
                <td>{{ $details->status ?? '-' }}</td>
                <td>{{ $details->client_contact_person_id ?? '-' }}</td>
                <td>{{ $details->source ?? '-' }}</td>
                <td>{{ $details->last_interaction ?? '-' }}</td>
                <td>{{ $details->next_step ?? '-' }}</td>
                <td>{{ $details->notes ?? '-' }}</td>
            </tbody>  
        <?php endforeach; ?>
    </table>
</div>

@include( 'crm.create' )
@endsection
