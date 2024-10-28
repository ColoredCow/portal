@extends('prospect::layouts.master')
@section('content')
    <div class="container">
        <br>
        <h4>Add New Prospect</h4>
        <div class="mt-5">
            @include('status', ['errors' => $errors->all()])
            <div class="card">
                <form action={{ route('prospect.store') }} method="POST" enctype="multipart/form-data" id="form_project">
                    @csrf
                    <div class="card-header">
                        <span>Prospect Details</span>
                    </div>
                    <div id="create_prospect_details_form">
                        <div class="card-body">
                            <input type="hidden" name="create_prospect" value="create_prospect">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="customer_type">{{ __('Customer Type') }}</label>
                                    <select name="customer_type" id="customer_type" class="form-control">
                                        <option value="">Select Customer Type</option>
                                        @foreach (config('prospect.customer-types') as $key => $customer_type)
                                            <option value="{{ $key }}"
                                                {{ old('customer_type') == $key ? 'selected' : '' }}>
                                                {{ $customer_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group offset-md-1 col-md-5" id="org_name_text_field">
                                    <label for="org_name" class="field-required">Organization Name</label>
                                    <input type="text" class="form-control" name="org_name" id="org_name"
                                        placeholder="Enter Organization Name" value="{{ old('org_name') }}" required>
                                </div>

                                <div class="form-group offset-md-1 col-md-5 d-none" id="org_name_select_field">
                                    <label for="client" class="field-required">Organization Name</label>
                                    <select class="form-control" name="client_id" id="org_name_select" required="required">
                                        <option value="">Select Organization Name</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="client_id" class="field-required">ColoredCow POC</label>
                                    <select name="poc_user_id" id="poc_user_id" class="form-control" required="required">
                                        <option value="">Select POC User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('poc_user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group offset-md-1  col-md-5">
                                    <label for="proposal_sent_date">Proposal Sent Date</label>
                                    <input type="date" class="form-control" name="proposal_sent_date"
                                        id="proposal_sent_date" value="{{ old('proposal_sent_date') }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="domain">{{ __('Domain') }}</label>
                                    <input type="text" class="form-control" name="domain" id="domain"
                                        placeholder="Enter Domain" value="{{ old('domain') }}">
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label for="budget">{{ __('Budget') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="currency" v-model="currency" id="currency"
                                                class="input-group-text">
                                                <option value="">Select Currency</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->currency }}">{{ $country->currency }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" name="budget" placeholder="Enter Budget"
                                            value="{{ old('budget') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="proposal_status">{{ __('Proposal Status') }}</label>
                                    <input type="text" class="form-control" name="proposal_status" id="proposal_status"
                                        placeholder="Enter Proposal Status" value="{{ old('proposal_status') }}">
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label for="rfp_link">{{ __('RFP Link') }}</label>
                                    <input type="url" class="form-control" name="rfp_link" id="rfp_link"
                                        placeholder="Enter RFP URL" value="{{ old('rfp_link') }}">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="proposal_link">{{ __('Proposal Link') }}</label>
                                    <input type="url" class="form-control" name="proposal_link" id="proposal_link"
                                        placeholder="Enter Proposal URL" value="{{ old('proposal_link') }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" id="save-btn-action">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
