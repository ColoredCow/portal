@extends('layouts.app')

@section('content')
<div class="container" id="home_page">
    <br>
    <div class="offset-md-3 col-md-6">
        <h1 class="form-row">Onboard your organization</h1>
        <br>
        <form action="{{ route('organizations.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Organization name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="admin_email">G Suite admin email</label>
                <input type="text" name="admin_email" id="admin_email" class="form-control">
            </div>
            <h2 class="mt-5 mb-3">G Suite API credentials</h2>
            <div class="form-group">
                <label class="d-block">Step 1</label>
                <a href="https://console.developers.google.com/projectcreate" target="_blank">Create a new project</a>
            </div>
            <div class="form-group">
                <label class="d-block">Step 2</label>
                <a href="https://console.developers.google.com/iam-admin/serviceaccounts" target="_blank">Create a service account</a>
                <p class="d-block text-dark"><strong>Note:&nbsp;</strong>Check the private key and domain-wide delegation options.</p>
            </div>
            <div class="form-group">
                <label for="gsuite_client_id">Service account client ID</label>
                <input type="text" name="gsuite_client_id" id="gsuite_client_id" class="form-control">
            </div>
            <div class="form-group">
                <label for="gsuite_dwd_private_key">Service account private key</label>
                <input type="file" name="gsuite_dwd_private_key" id="gsuite_dwd_private_key" class="form-control-file">
                <small class="form-text text-muted">We'll never share these credentials with anyone else.</small>
            </div>
            <div class="form-group">
                <label class="d-block">Step 3: Enable APIs</label>
                <ul>
                    <li><a href="https://console.developers.google.com/apis/api/admin.googleapis.com/overview" target="_blank" class="d-block">Enable Admin SDK</a></li>
                    <li><a href="https://console.developers.google.com/apis/library/calendar-json.googleapis.com" target="_blank" class="d-block">Enable Calendar API</a></li>
                </ul>
            </div>
            <div class="form-group">
                <label for="workspace">Your workspace name</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="myorganization" name="workspace" id="workspace">
                    <div class="input-group-append">
                        <span class="input-group-text">.coloredcow.com</span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3 px-4">Submit</button>
        </form>
    </div>
</div>
@endsection
