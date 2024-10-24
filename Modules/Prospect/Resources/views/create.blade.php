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
                                    <label for="name" class="field-required">Organization Name</label>
                                    <input type="text" class="form-control" name="org_name" id="org_name"
                                        placeholder="Enter Organization Name" required="required"
                                        value="{{ old('org_name') }}">
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
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
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="proposal_sent_date" class="field-required">Proposal Sent Date</label>
                                    <input type="date" class="form-control" name="proposal_sent_date"
                                        id="proposal_sent_date" value="{{ old('proposal_sent_date') }}" required="required">
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label for="domain" class="field-required">{{ __('Domain') }}</label>
                                    <input type="text" class="form-control" name="domain" id="domain"
                                        placeholder="Enter Domain" value="{{ old('domain') }}" required="required">
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="customer_type" class="field-required">{{ __('Customer Type') }}</label>
                                    <select name="customer_type" id="customer_type" class="form-control"
                                        required="required">
                                        <option value="">Select Customer Type</option>
                                        @foreach (config('prospect.customer-types') as $key => $customer_type)
                                            <option value="{{ $key }}"
                                                {{ old('customer_type') == $key ? 'selected' : '' }}>
                                                {{ $customer_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label for="budget" class="field-required">{{ __('Budget') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="currency" v-model="currency" id="currency"
                                                class="input-group-text" required="required">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->currency }}">{{ $country->currency }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="number" class="form-control" name="budget" placeholder="Enter Budget"
                                            required="required" step=".01" min="0" value="{{ old('budget') }}">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="proposal_status" class="field-required">{{ __('Proposal Status') }}</label>
                                    <input type="text" class="form-control" name="proposal_status" id="proposal_status"
                                        placeholder="Enter Proposal Status" required="required"
                                        value="{{ old('proposal_status') }}">
                                </div>
                                <div class="form-group offset-md-1 col-md-5">
                                    <label for="rfp_link" class="field-required">{{ __('RFP Link') }}</label>
                                    <input type="url" class="form-control" name="rfp_link" id="rfp_link"
                                        placeholder="Enter RFP URL" value="{{ old('rfp_link') }}">
                                </div>
                            </div>
                            <br />
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="proposal_link" class="field-required">{{ __('Proposal Link') }}</label>
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
