@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('settings.menu', ['active' => 'hr'])
    <br><br>
    <h1>Settings</h1>
    <br>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="{{ url('/settings/hr/update') }}" method="POST">
            {{ csrf_field() }}

            <div class="card-header">Auto responder mail to applicant</div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="setting_key[applicant_welcome_mail_subject]">Subject</label>
                            <input type="text" name="setting_key[applicant_welcome_mail_subject]" class="form-control" value="{{ isset($settings['applicant_welcome_mail_subject']->setting_value) ? $settings['applicant_welcome_mail_subject']->setting_value : '' }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="setting_key[applicant_welcome_mail_body]">Mail body:</label>
                            <textarea name="setting_key[applicant_welcome_mail_body]" rows="10" class="richeditor form-control" placeholder="Body">{{ isset($settings['applicant_welcome_mail_body']->setting_value) ? $settings['applicant_welcome_mail_body']->setting_value : '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
