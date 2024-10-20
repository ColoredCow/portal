@extends('prospect::layouts.master')
@section('content')
    <div class="container">
        <br>
        <h4>View Prospect</h4>
        <div class="mt-5">
            @include('status', ['errors' => $errors->all()])
            <div class="card">
                <div class="card-header">
                    <span>Prospect Details</span>
                </div>
                <div id="create_prospect_details_form">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group
                                col-md-5">
                                <label for="name" class="field-required">Organization Name</label>
                                <input type="text" class="form-control" name="org_name" id="org_name"
                                    placeholder="Enter Organization Name" required="required"
                                    value="{{ $prospect->org_name }}" readonly>
                            </div>
                            <div class="form-group
                                offset-md-1 col-md-5">
                                <label for="client_id" class="field-required">ColoredCow POC</label>
                                <input type="text" class="form-control" name="poc_user_id" id="poc_user_id"
                                    value="{{ $prospect->pocUser->name }}" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="proposal_sent_date" class="field-required">Proposal Sent Date</label>
                                <input type="date" class="form-control" name="proposal_sent_date" id="proposal_sent_date"
                                    value="{{ $prospect->proposal_sent_date }}" readonly>
                            </div>
                            <div class="form-group
                                offset-md-1 col-md-5">
                                <label for="domain" class="field-required">{{ __('Domain') }}</label>
                                <input type="text" class="form-control" name="domain" id="domain"
                                    value="{{ $prospect->domain }}" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group
                                col-md-5">
                                <label for="customer_type" class="field-required">{{ __('Customer Type') }}</label>
                                <input type="text" class="form-control" name="customer_type" id="customer_type"
                                    value="{{ config('prospect.customer-types')[$prospect->customer_type] }}" readonly>
                            </div>
                            <div class="form-group
                                offset-md-1 col-md-5">
                                <label for="status" class="field-required">{{ __('Status') }}</label>
                                <input type="text" class="form-control" name="status" id="status"
                                    value="{{ $prospect->status }}" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="created_at" class="field-required">Created At</label>
                                <input type="text" class="form-control" name="created_at" id="created_at"
                                    value="{{ $prospect->created_at }}" readonly>
                            </div>
                            <div class="form-group
                                offset-md-1 col-md-5">
                                <label for="updated_at" class="field-required">Updated At</label>
                                <input type="text" class="form-control" name="updated_at" id="updated_at"
                                    value="{{ $prospect->updated_at }}" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group
                                col-md-5">
                                <label for="budget" class="field-required">{{ __('Budget') }}</label>
                                <input type="text" class="form-control" name="budget" id="budget"
                                    value="{{ $prospect->budget }}" readonly>
                            </div>
                            <div class="form-group
                                offset-md-1 col-md-5">
                                <label for="proposal_status" class="field-required">{{ __('Proposal Status') }}</label>
                                <input type="text" class="form-control" name="proposal_status" id="proposal_status"
                                    value="{{ $prospect->proposal_status }}" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="rfp_url">{{ __('RFP URL') }}</label>
                                <input type="url" class="form-control" name="rfp_url" id="rfp_url"
                                    value="{{ $prospect->rfp_link }}" readonly>
                            </div>
                            <div class="form-group
                                offset-md-1 col-md-5">
                                <label for="proposal_url">{{ __('Proposal URL') }}</label>
                                <input type="url" class="form-control" name="proposal_url" id="proposal_url"
                                    value="{{ $prospect->proposal_link }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
