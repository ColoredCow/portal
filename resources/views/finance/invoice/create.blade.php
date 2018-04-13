@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Create Invoice</h1>
    <br>
    <a class="btn btn-info" href="/finance/invoices">See all invoices</a>
    <br><br>
    @include('status', ['errors' => $errors->all()])
    <br>
    <div class="card">
        <form action="/finance/invoices" method="POST" enctype="multipart/form-data" id="form_invoice" class="form-invoice">

            {{ csrf_field() }}

            <div class="card-header">
                <span>Invoices Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="client_id" class="field-required">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required="required">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                @php
                                    $selected = old('client_id') == $client->id ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $client->id }}" {{ $selected }}>{{ $client->name }}</option>
                                }
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="project_id" class="field-required">Project</label>
                        <select name="project_ids[]" id="project_ids" class="form-control" required="required" multiple="multiple">
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="project_invoice_id" class="field-required">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required" value="{{ old('project_invoice_id') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="status" class="field-required">Status</label>
                        <select name="status" id="status" class="form-control" required="required">
                        @foreach (config('constants.finance.invoice.status') as $status => $display_name)
                            @php
                                $selected = old('status') == $status ? 'selected="selected"' : '';
                            @endphp
                            <option value="{{ $status }}" {{ $selected }}>{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="sent_on" class="field-required">Sent on</label>
                        <input type="text" class="form-control date-field" name="sent_on" id="sent_on" placeholder="dd/mm/yyyy" required="required"  value="{{ old('sent_on') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="sent_amount" class="field-required">Invoice amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_sent_amount" id="currency_sent_amount" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = old('currency_sent_amount') == $currency ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="sent_amount" id="sent_amount" placeholder="Invoice Amount" required="required" step=".01" min="0" value="{{ old('sent_amount') }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="gst">GST amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="btn btn-secondary">
                                    <option>INR</option>
                                </select>
                            </div>
                            <input type="number" class="form-control" name="gst" id="gst" placeholder="GST amoount" step=".01" min="0" value="{{ old('gst') }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="paid_on">Paid on</label>
                        <input type="text" class="form-control date-field" name="paid_on" id="paid_on" placeholder="dd/mm/yyyy" value="{{ old('paid_on') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="paid_amount">Received amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_paid_amount" id="currency_paid_amount" class="btn btn-secondary">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = old('currency_paid_amount') == $currency ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="paid_amount" id="paid_amount" placeholder="Received Amount" step=".01" min="0" value="{{ old('paid_amount') }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="payment_type">Payment type</label>
                        <select name="payment_type" id="payment_type" class="form-control" v-model="paymentType">
                            <option value="">Select payment type</option>
                            @foreach (config('constants.payment_types') as $payment_type => $display_name)
                                @php
                                    $selected = old('payment_type') == $payment_type ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $payment_type }}" {{ $selected }}>{{ $display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5 cheque-status" v-show="paymentType == 'cheque'">
                        <label for="cheque_status">Cheque status</label>
                        <select name="cheque_status" id="cheque_status" class="form-control">
                            <option value="">Select cheque status</option>
                            @foreach (config('constants.cheque_status') as $cheque_status => $display_name)
                                @php
                                    $selected = old('cheque_status') == $cheque_status ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $cheque_status }}" {{ $selected }}>{{ $display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="tds">TDS amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_tds" id="currency_tds" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = $currency == old('currency_tds') ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="tds" id="tds" placeholder="TDS Amount" step=".01" min="0" value="{{ old('tds') }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="invoice_file" class="field-required">Upload Invoice</label>
                        <div><input id="invoice_file" name="invoice_file" type="file" required="required"></div>
                    </div>
                </div>
                <br>
                <div class="form-row">
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
