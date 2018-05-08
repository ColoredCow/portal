@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'invoices'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Edit Invoice</h1></div>
        <div class="col-md-6"><a href="/finance/invoices/create" class="btn btn-success float-right">Create Invoice</a></div>
    </div>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="/finance/invoices/{{ $invoice->id }}" method="POST" enctype="multipart/form-data" id="form_invoice" class="form-invoice">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="card-header">
                <span>Invoices Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="client_id" class="field-required">Client</label>
                        <select name="client_id" id="client_id" class="form-control" required="required" disabled="disabled">
                            <option value="">Select Client</option>
                            @foreach ($clients as $client)
                                @php
                                    $selected = $client->id === $invoice_client->id ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $client->id }}" {{ $selected }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <invoice-project-component
                :billings="{{ json_encode($invoice_billings) }}"
                :client="{{ json_encode($invoice_client) }}">
                </invoice-project-component>
                <br>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="project_invoice_id" class="field-required">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required" value="{{ $invoice->project_invoice_id }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="sent_on" class="field-required">Sent on</label>
                        <input type="text" class="form-control date-field" name="sent_on" id="sent_on" placeholder="dd/mm/yyyy" required="required" value="{{ date(config('constants.display_date_format'), strtotime($invoice->sent_on)) }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-3">
                        <label for="sent_amount" class="field-required">Invoice amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_sent_amount" id="currency_sent_amount" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = $currency === $invoice->currency_sent_amount ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="sent_amount" id="sent_amount" placeholder="Invoice Amount" required="required" step=".01" min="0" value="{{ $invoice->sent_amount }}">
                        </div>
                    </div>
                @if ($invoice_client->country == 'india')
                    <div class="form-group col-md-2">
                        <label for="gst">GST</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="btn btn-secondary">
                                    <option>INR</option>
                                </select>
                            </div>
                            <input type="number" class="form-control" name="gst" id="gst" placeholder="GST" step=".01" min="0" value="{{ $invoice->gst }}">
                        </div>
                    </div>
                @endif
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="name" class="field-required">Status</label>
                        <select name="status" id="status" class="form-control" required="required" v-model="status" data-status="{{ $invoice->status }}">
                        @foreach (config('constants.finance.invoice.status') as $status => $display_name)
                            <option value="{{ $status }}">{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3" v-show="status == 'paid'">
                        <label for="paid_on">Paid on</label>
                        @php
                            $paid_on = $invoice->paid_on ? date(config('constants.display_date_format'), strtotime($invoice->paid_on)) : $invoice->paid_on;
                        @endphp
                        <input type="text" class="form-control date-field" name="paid_on" id="paid_on" placeholder="dd/mm/yyyy" value="{{ $paid_on }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-3" v-show="status == 'paid'">
                        <label for="paid_amount">Received amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_paid_amount" id="currency_paid_amount" class="btn btn-secondary" v-model="paidAmountCurrency" data-paid-amount-currency="{{ $invoice->currency_paid_amount }}">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="paid_amount" id="paid_amount" placeholder="Received Amount" step=".01" min="0" v-model="paidAmount" data-paid-amount="{{ $invoice->paid_amount }}">
                        </div>
                    </div>
                    <div class="form-group col-md-2" v-show="status == 'paid' && activeClient.hasOwnProperty('country') && activeClient.country == 'india'">
                        <label for="tds">TDS deducted</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_tds" id="currency_tds" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = $currency === $invoice->currency_tds ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="tds" id="tds" placeholder="TDS" step=".01" min="0" value="{{ $invoice->tds }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row" v-show="status == 'paid'">
                    <div class="form-group col-md-2">
                        <label for="bank_charges">Bank charges</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_transaction_charge" id="currency_transaction_charge" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = $currency === $invoice->currency_transaction_charge ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="transaction_charge" id="transaction_charge" placeholder="amount" step=".01" min="0" value="{{ $invoice->transaction_charge }}">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="bank_taxes">ST on fund transfer</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_transaction_tax" id="currency_transaction_tax" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = $currency === $invoice->currency_transaction_tax ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="transaction_tax" id="transaction_tax" placeholder="amount" step=".01" min="0" value="{{ $invoice->transaction_tax }}">
                        </div>
                    </div>
                    <div class="form-group offset-md-2 col-md-4" v-show="paidAmountCurrency != 'INR'">
                        <label for="conversion_rate">Conversion rate</label>
                        <div class="d-flex align-items-center">
                            <input type="number" class="form-control" name="conversion_rate" id="conversion_rate" placeholder="conversion rate" step="0.01" min="0" v-model="conversionRate" data-conversion-rate="{{ $invoice->conversion_rate }}">
                            <h4 class="my-0 mx-2">&rArr;</h4>
                            <h4 class="my-0 mx-2">{{ config('constants.currency.INR.symbol') }}&nbsp;@{{ convertedAmount }}</h4>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row" v-show="status == 'paid'">
                    <div class="form-group col-md-5">
                        <label for="payment_type">Payment type</label>
                        <select name="payment_type" id="payment_type" class="form-control" v-model="paymentType" data-payment-type="{{ $invoice->payment_type }}">
                            <option value="">Select payment type</option>
                            @foreach (config('constants.payment_types') as $payment_type => $display_name)
                                @php
                                    $selected = $invoice->payment_type == $payment_type ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $payment_type }}" {{ $selected }}>{{ $display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-3 cheque-status" v-show="paymentType == 'cheque'">
                        <label for="cheque_status">Cheque status</label>
                        <select name="cheque_status" id="cheque_status" class="form-control" v-model="chequeStatus" data-cheque-status="{{ $invoice->cheque_status }}">
                            <option value="">Select cheque status</option>
                            @foreach (config('constants.cheque_status') as $cheque_status => $display_name)
                                <option value="{{ $cheque_status }}">{{ $display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2" v-show="paymentType == 'cheque' && chequeStatus == 'received'">
                        <label for="cheque_received_date">Cheque Received Date</label>
                        <input type="text" class="form-control date-field" name="cheque_received_date" id="cheque_received_date" placeholder="dd/mm/yyyy" value="{{ $invoice->cheque_received_date ? date(config('constants.display_date_format'), strtotime($invoice->cheque_received_date)) : '' }}">
                    </div>
                    <div class="form-group col-md-2" v-show="paymentType == 'cheque' && chequeStatus == 'cleared'">
                        <label for="cheque_cleared_date">Cheque Cleared Date</label>
                        <input type="text" class="form-control date-field" name="cheque_cleared_date" id="cheque_cleared_date" placeholder="dd/mm/yyyy" value="{{ $invoice->cheque_cleared_date ? date(config('constants.display_date_format'), strtotime($invoice->cheque_cleared_date)) : '' }}">
                    </div>
                    <div class="form-group col-md-2" v-show="paymentType == 'cheque' && chequeStatus == 'bounced'">
                        <label for="cheque_bounced_date">Cheque Bounced Date</label>
                        <input type="text" class="form-control date-field" name="cheque_bounced_date" id="cheque_bounced_date" placeholder="dd/mm/yyyy" value="{{ $invoice->cheque_bounced_date ? date(config('constants.display_date_format'), strtotime($invoice->cheque_bounced_date)) : '' }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                    @if ($invoice->file_path)
                        <label class="font-weight-bold">Invoice File</label>
                        <div>
                            <a href="/finance/invoices/download/{{ $invoice->file_path }}"><i class="fa fa-file fa-3x text-primary btn-file"></i></a>
                        </div>
                    @else
                        <label for="invoice_file" class="field-required">Upload Invoice</label>
                        <div><input id="invoice_file" name="invoice_file" type="file" required="required"></div>
                    @endif
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="comments">Comments</label>
                        <textarea name="comments" id="comments" rows="5" class="form-control">{{ $invoice->comments }}</textarea>
                    </div>
                </div>
                <br>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
