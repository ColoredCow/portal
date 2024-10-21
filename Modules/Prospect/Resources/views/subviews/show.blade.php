@extends('prospect::layouts.master')
@section('content')
    <div class="container">
        <br>
        <h4 class="mb-5 font-weight-bold">Prospect Name:- {{ $prospect->organization_name }}</h4>
        <div class="card-header d-flex" data-toggle="collapse" data-target="#prospect-details">
            <h5 class="font-weight-bold">Prospect Details</h5>
            <span class="arrow ml-auto">&#9660;</span>
        </div>
        <div id="prospect-details" class="collapse card mt-3">
            <div class="panel-body">
                <br>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="org_name" class="font-weight-bold">Organization Name:</label>
                            <span class="ml-2">{{ $prospect->organization_name }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="poc_user_id" class="font-weight-bold">ColoredCow POC:</label>
                            <span class="ml-2">{{ $prospect->pocUser->name }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="proposal_sent_date" class="font-weight-bold">Proposal Sent Date:</label>
                            <span class="ml-2">{{ $prospect->proposal_sent_date }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="domain" class="font-weight-bold">Domain:</label>
                            <span class="ml-2">{{ $prospect->domain }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="customer_type" class="font-weight-bold">Customer Type:</label>
                            <span class="ml-2">{{ config('prospect.customer-types')[$prospect->customer_type] }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="budget" class="font-weight-bold">Budget:</label>
                            <span class="ml-2">{{ $prospect->budget }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="proposal_status" class="font-weight-bold">Proposal Status:</label>
                            <span class="ml-2">{{ $prospect->proposal_status }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="proposal_url" class="font-weight-bold">Proposal URL:</label>
                            <a href="{{ $prospect->proposal_link }}" target="_blank" class="ml-2"><i
                                    class="fa fa-external-link"></i></a>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label for="rfp_url" class="font-weight-bold">RFP URL:</label>
                            <a href="{{ $prospect->rfp_link }}" target="_blank" class="ml-2"><i
                                    class="fa fa-external-link"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
