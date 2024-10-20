@extends('prospect::layouts.master')
@section('content')
    <div class="container">
        <br>
        <h4>Add new Prospect</h4>
        <div class="">
            @include('status', ['errors' => $errors->all()])
            <div class="card">
                <form action="" method="POST" enctype="multipart/form-data" id="form_project">
                    @csrf
                    <div class="card-header">
                        <span>Prospect Details</span>
                    </div>
                    <div id="create_project_details_form">
                        <div class="card-body">
                            <input type="hidden" name="create_project" value="create_project">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="name" class="field-required">Organization Name</label>
                                    <input type="text" class="form-control" name="org_name" id="org_name"
                                        placeholder="Enter Organization Name" required="required"
                                        value="{{ old('org_name') }}">
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label for="client_id" class="field-required">ColoredCow POC</label>
                                    <select name="coloredcow_poc" id="coloredcow_poc" class="form-control"
                                        required="required">
                                        <option value="">Select user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('coloredcow_poc') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="proposal_sent_date">Proposal Sent Date</label>
                                    <input type="date" class="form-control" name="proposal_sent_date"
                                        id="proposal_sent_date" value="{{ old('proposal_sent_date') }}">
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label for="domain">{{ __('Dmain') }}</label>
                                    <input type="text" class="form-control" name="domain" id="domain"
                                        placeholder="Enter Domain" required="required" value="{{ old('domain') }}">
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary mb-10" id="save-btn-action">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
