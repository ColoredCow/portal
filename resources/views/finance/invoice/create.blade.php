@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'invoices'])
    <br><br>
    <h1>Create Invoice</h1>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="/finance/invoices" method="POST" enctype="multipart/form-data" id="form_invoice" class="form-invoice form-create-invoice">
            @csrf
            <div class="card-header">
                <span>Invoices Details</span>
            </div>
            <div class="card-body">
                <div class="form-row mb-4">
                    <div class="form-group col-md-5">
                        <label for="client_id" class="field-required">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required="required" v-model="selectedClient" data-clients="{{ $clients }}" @change="updateActiveClient" data-countries="{{ json_encode(config('constants.countries')) }}">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                @php
                                    $selected = old('client_id') == $client->id ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $client->id }}" data-pre-select-client="{{ $client }}" {{ $selected }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <invoice-project-component
                :billings="{{ json_encode([]) }}"
                :client="activeClient">
                </invoice-project-component>
                <div class="form-row mb-4">
                    <div class="form-group col-md-2">
                        <label for="project_invoice_id" class="field-required">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required" value="{{ old('project_invoice_id') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="sent_on" class="field-required">Sent on</label>
                        <input type="date" class="form-control" name="sent_on" id="sent_on" placeholder="{{ config('constants.finance.input_date_format') }}" required="required"  value="{{ old('sent_on') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-3">
                        <label for="invoice_amount" class="field-required">Invoice amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="invoice_currency" id="invoice_currency" class="btn btn-secondary" required="required" v-model="activeClientCurrency">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = old('invoice_currency') == $currency ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="invoice_amount" id="invoice_amount" placeholder="Invoice Amount" required="required" step=".01" min="0" v-model="sentAmount" data-sent-amount="{{ old('invoice_amount') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-2" v-show="activeClient.hasOwnProperty('country') && activeClient.country == 'india'">
                        <label for="gst">GST</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="btn btn-secondary">
                                    <option>INR</option>
                                </select>
                            </div>
                            <input type="number" class="form-control" name="gst" id="gst" placeholder="GST" step=".01" min="0" value="{{ old('gst') }}">
                        </div>
                    </div>
                </div>
                <div class="form-row mb-4">
                    <div class="form-group col-md-3">
                        <label for="due_on">Due date</label>
                        <input type="date" class="form-control" name="due_on" id="due_on" placeholder="{{ config('constants.finance.input_date_format') }}"  value="{{ old('due_on') }}">
                    </div>
                </div>
                <div class="form-row mb-4">
                    <div class="form-group col-md-5">
                        <label for="invoice_file" class="field-required">Upload Invoice</label>
                        <div><input id="invoice_file" name="invoice_file" type="file" required="required"></div>
                    </div>
                </div>
                <div class="form-row mb-4">
                    <div class="form-group col-md-5">
                        <label for="comments">Comments</label>
                        <textarea name="comments" id="comments" rows="5" class="form-control">{{ old('comments') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
