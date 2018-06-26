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
                <label class="d-block">Step 1:</label>
                <a href="https://console.developers.google.com/projectcreate" target="_blank">Create a new project</a>
            </div>
            <div class="form-group">
                <label class="d-block">Step 2:</label>
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
                    <li><a href="https://console.developers.google.com/apis/api/admin.googleapis.com/overview" target="_blank">Enable Admin SDK</a></li>
                    <li><a href="https://console.developers.google.com/apis/library/calendar-json.googleapis.com" target="_blank">Enable Calendar API</a></li>
                </ul>
            </div>
            <div class="form-group">
                <label class="mb-0">Step 4: Enable domain wide delegation for your G Suite account.</label>
                <p class="form-text text-muted mb-1">This will help us to access your following organizational G Suite details without troubling your team members for their consent.</p>
                <ul>
                    <li><a href="https://admin.google.com">Go to your G Suite domain's admin console</a></li>
                    <li>Select <strong>Security</strong> from the list of controls. If you don't see <strong>Security</strong> listed, select <strong>More controls</strong> from the gray bar at the bottom of the page, then select <strong>Security</strong> from the list of controls.</li>
                    <li>Select <strong>Advanced settings</strong> from the list of options.</li>
                    <li>Select <strong>Manage API client access</strong> in the <strong>Authentication</strong> section.</li>
                    <li>In the <strong>Client name</strong> field enter the service account's <strong>Client ID</strong>.</li>
                    <li>Copy the following text and paste them in the <strong>One or More API Scopes</strong> field:</li>
                    <div class="card card-block flex-row align-items-start mt-2 mb-4 p-2 bg-light" id="weeklydose_service_url">
                        <p class="text-wrap mb-0">https://www.googleapis.com/auth/calendar, https://www.googleapis.com/auth/calendar.readonly, https://www.googleapis.com/auth/admin.directory.user, https://www.googleapis.com/auth/admin.directory.user.readonly</p>
                        <button type="button" class="btn btn-secondary btn-clipboard" id="copy_weeklydose_service_url" data-clipboard-target="#weeklydose_service_url" data-original-title="Copy to clipboard">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                    <li>Click the <strong>Authorize</strong> button.</li>
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
