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

            {{ csrf_field() }}

            <div class="card-header">
                <span>Invoices Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
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
                <br>
                <invoice-project-component
                :billings="{{ json_encode([]) }}"
                :client="activeClient">
                </invoice-project-component>
                <br>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="project_invoice_id" class="field-required">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required" value="{{ old('project_invoice_id') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="sent_on" class="field-required">Sent on</label>
                        <input type="text" class="form-control date-field" name="sent_on" id="sent_on" placeholder="dd/mm/yyyy" required="required"  value="{{ old('sent_on') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="due_date" class="field-required">Due date</label>
                        <input type="date" class="form-control date-field" name="due_date" id="due_date" placeholder="dd/mm/yyyy" value="{{ old('due_date') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-3">
                        <label for="sent_amount" class="field-required">Invoice amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_sent_amount" id="currency_sent_amount" class="btn btn-secondary" required="required" v-model="activeClientCurrency">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = old('currency_sent_amount') == $currency ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="sent_amount" id="sent_amount" placeholder="Invoice Amount" required="required" step=".01" min="0" v-model="sentAmount" data-sent-amount="{{ old('sent_amount') }}">
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
                <br>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="status" class="field-required">Status</label>
                        <select name="status" id="status" class="form-control" required="required" v-model="status" data-status="{{ old('status') ?? 'unpaid' }}">
                        @foreach (config('constants.finance.invoice.status') as $status => $display_name)
                            <option value="{{ $status }}">{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3" v-show="status == 'paid'">
                        <label for="paid_on">Paid on</label>
                        <input type="text" class="form-control date-field" name="paid_on" id="paid_on" placeholder="dd/mm/yyyy" value="{{ old('paid_on') }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-3" v-show="status == 'paid'">
                        <label for="paid_amount">Received amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_paid_amount" id="currency_paid_amount" class="btn btn-secondary" v-model="activeClientCurrency" data-paid-amount-currency="{{ old('currency_paid_amount') }}">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="paid_amount" id="paid_amount" placeholder="Received Amount" step=".01" min="0" v-model="paidAmount" data-paid-amount="{{ old('paid_amount') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-2" v-show="status == 'paid' && activeClient.hasOwnProperty('country') && activeClient.country == 'india'">
                        <label for="tds">TDS deducted</label>
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
                            <input type="number" class="form-control" name="tds" id="tds" placeholder="TDS" step=".01" min="0" v-model="tdsAmount" data-tds="{{ old('tds') }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row" v-show="status == 'paid'">
                    <div class="form-group col-md-3">
                        <label for="bank_charges">Bank charges on fund transfer</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_transaction_charge" id="currency_transaction_charge" class="btn btn-secondary" required="required" v-model="currencyTransactionCharge" data-currency-transaction-charge="{{ old('currency_transaction_charge') }}">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="transaction_charge" id="transaction_charge" placeholder="amount" step=".01" min="0" v-model="transactionCharge" data-transaction-charge="{{ old('transaction_charge') }}">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="bank_taxes">ST on fund transfer</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_transaction_tax" id="currency_transaction_tax" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = $currency === old('currency_transaction_tax') ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="transaction_tax" id="transaction_tax" placeholder="amount" step=".01" min="0" value="{{ old('transaction_tax') }}">
                        </div>
                    </div>
                    <div class="form-group offset-md-1 col-md-3" v-show="activeClientCurrency != 'INR'">
                        <label for="conversion_rate">Conversion rate</label>
                        <div class="d-flex flex-column">
                            <input type="number" class="form-control" name="conversion_rate" id="conversion_rate" placeholder="conversion rate" step="0.01" min="0" v-model="conversionRate" data-conversion-rate="{{ old('conversion_rate') }}">
                            <div class="mt-3 mb-0">
                                <p class="m-0">Received amount after conversion&nbsp;&nbsp;</p>
                                <h4 class="m-0">{{ config('constants.currency.INR.symbol') }}&nbsp;@{{ convertedAmount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" :class="[activeClientCurrency == 'INR' ? 'offset-md-1 col-md-3' : 'col-md-2']">
                        <label for="due_amount">Balance left</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_due_amount" id="currency_due_amount" class="btn btn-secondary" required="required" v-model="currencyDueAmount" data-currency-due-amount="{{ old('currency_due_amount') }}">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="due_amount" id="due_amount" placeholder="balance left" step=".01" min="0" v-model="suggestedDueAmount" data-due-amount="{{ old('due_amount') }}">
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-row" v-show="status == 'paid'">
                    <div class="form-group col-md-5">
                        <label for="payment_type">Payment type</label>
                        <select name="payment_type" id="payment_type" class="form-control" v-model="paymentType" data-payment-type="{{ old('payment_type') }}">
                            <option value="">Select payment type</option>
                            @foreach (config('constants.payment_types') as $payment_type => $display_name)
                                @php
                                    $selected = old('payment_type') == $payment_type ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $payment_type }}" {{ $selected }}>{{ $display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-3 cheque-status" v-show="paymentType == 'cheque'">
                        <label for="cheque_status">Cheque status</label>
                        <select name="cheque_status" id="cheque_status" class="form-control" v-model="chequeStatus" data-cheque-status="{{ old('cheque_status') }}">
                            <option value="">Select cheque status</option>
                            @foreach (config('constants.cheque_status') as $cheque_status => $display_name)
                                <option value="{{ $cheque_status }}">{{ $display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2" v-show="paymentType == 'cheque' && chequeStatus == 'received'">
                        <label for="cheque_received_date">Cheque Received Date</label>
                        <input type="text" class="form-control date-field" name="cheque_received_date" id="cheque_received_date" placeholder="dd/mm/yyyy" value="{{ old('cheque_received_date') ? date(config('constants.display_date_format'), strtotime(old('cheque_received_date'))) : '' }}">
                    </div>
                    <div class="form-group col-md-2" v-show="paymentType == 'cheque' && chequeStatus == 'cleared'">
                        <label for="cheque_cleared_date">Cheque Cleared Date</label>
                        <input type="text" class="form-control date-field" name="cheque_cleared_date" id="cheque_cleared_date" placeholder="dd/mm/yyyy" value="{{ old('cheque_cleared_date') ? date(config('constants.display_date_format'), strtotime(old('cheque_cleared_date'))) : '' }}">
                    </div>
                     
                    <div class="form-group col-md-2" v-show="paymentType == 'cheque' && chequeStatus == 'bounced'">
                        <label for="cheque_bounced_date">Cheque Bounced Date</label>
                        <input type="text" class="form-control date-field" name="cheque_bounced_date" id="cheque_bounced_date" placeholder="dd/mm/yyyy" value="{{ old('cheque_bounced_date') ? date(config('constants.display_date_format'), strtotime(old('cheque_bounced_date'))) : '' }}">
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
                <br>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
