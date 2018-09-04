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
                        <select name="client_id" id="client_id" class="form-control" required="required" disabled="disabled" data-active-client="{{$invoice_client}}">
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
                <invoice-project-component
                    :billings="{{ json_encode($invoice_billings) }}"
                    :client="{{ json_encode($invoice_client) }}">
                </invoice-project-component>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="project_invoice_id" class="field-required">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required" value="{{ $invoice->project_invoice_id }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="sent_on" class="field-required">Sent on</label>
                        <input type="date" class="form-control" name="sent_on" id="sent_on" placeholder="{{ config('constants.finance.input_date_format') }}" required="required" value="{{ $invoice->sent_on }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-3">
                        <label for="invoice_amount" class="field-required">Invoice amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="invoice_currency" id="invoice_currency" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = $currency === $invoice->currency ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="invoice_amount" id="invoice_amount" placeholder="Invoice Amount" required="required" step=".01" min="0" v-model="sentAmount" data-sent-amount="{{ $invoice->amount }}">
                        </div>
                    </div>
                    @if ($invoice_client->country == 'india')
                    <div class="form-group col-md-3">
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
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="due_on">Due date</label>
                        <input type="date" class="form-control" name="due_on" id="due_on" placeholder="{{ config('constants.finance.input_date_format') }}" value="{{ $invoice->due_on }}">
                    </div>
                </div>
                <div class="form-row">
                    {{-- <div class="form-group col-md-2">
                        <label for="name" class="field-required">Status</label>
                        <select name="status" id="status" class="form-control" required="required" v-model="status" data-status="{{ $invoice->status }}">
                        @foreach (config('constants.finance.invoice.status') as $status => $display_name)
                            <option value="{{ $status }}">{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div> --}}
                    <div class="form-group col-md-3" v-if="status == 'paid'">
                        <label for="paid_at" class="field-required">Paid on</label>
                        <input type="date" required="required" class="form-control" name="paid_at" id="paid_at" placeholder="{{config('constants.finance.input_date_format')}}" value="{{ $invoice->payments->first()->paid_at }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-3">
                        <label for="payment_amount" class="field-required">Payment amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="payment_currency" required="required" id="payment_currency" class="btn btn-secondary" v-model="activeClientCurrency" data-paid-amount-currency="{{ $invoice->payments->first()->currency }}">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="payment_amount" id="payment_amount" placeholder="Payment amount" step=".01" min="0" v-model="paidAmount" data-paid-amount="{{ $invoice->payments->first()->amount }}">
                        </div>
                    </div>
                    <div class="form-group col-md-2" v-show="status == 'paid' && activeClient.hasOwnProperty('country') && activeClient.country == 'india'">
                        <label for="tds">TDS deducted</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_tds" id="currency_tds" class="btn btn-secondary" required="required">
                                    <option>INR</option>
                                </select>
                            </div>
                            <input type="number" class="form-control" name="tds" id="tds" placeholder="TDS" step=".01" min="0" v-model="tdsAmount" data-tds="{{ $invoice->payments->first()->tds }}">
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="bank_charges">Bank charges on fund transfer</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="payment_currency" id="payment_currency" class="btn btn-secondary" required="required" data-currency-transaction-charge="{{ $invoice->payments->first()->currency }}">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="bank_charges" id="bank_charges" placeholder="amount" step=".01" min="0" v-model="transactionCharge" data-transaction-charge="{{ $invoice->payments->first()->bank_charges }}">
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="bank_service_tax_forex">ST on fund transfer</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="btn btn-secondary">
                                    <option>INR</option>
                                </select>
                            </div>
                            <input type="number" class="form-control" name="bank_service_tax_forex" id="bank_service_tax_forex" placeholder="amount" step=".01" min="0" value="{{ $invoice->payments->first()->bank_service_tax_forex }}">
                        </div>
                    </div>
                    <div class="form-group offset-md-1 col-md-3" v-show="activeClientCurrency != 'INR'">
                        <label for="conversion_rate">Conversion rate</label>
                        <div class="d-flex flex-column">
                            <input type="number" class="form-control" name="conversion_rate" id="conversion_rate" placeholder="conversion rate" step="0.01" min="0" v-model="conversionRate" data-conversion-rate="{{ $invoice->payments->first()->conversion_rate }}">
                            <div class="mt-3 mb-0">
                                <p class="m-0">Payment amount after conversion&nbsp;&nbsp;</p>
                                <h4 class="m-0">{{ config('constants.currency.INR.symbol') }}&nbsp;@{{ convertedAmount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-2" v-if="status == 'paid'">
                    <div class="form-group col-md-5">
                        <label for="payment_mode" class="field-required">Payment mode</label>
                        <select name="payment_mode" id="payment_mode" class="form-control" required="required" v-model="paymentType" data-payment-type="{{ $invoice->payment_mode }}">
                            <option value="">Select payment mode</option>
                            @foreach (config('constants.payment_modes') as $payment_mode => $display_name)
                                @php
                                    $selected = $invoice->payment_mode == $payment_mode ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $payment_mode }}" {{ $selected }}>{{ $display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="form-group offset-md-1 col-md-3 cheque-status" v-if="paymentType == 'cheque'">
                        <label for="cheque_status" class="field-required">Cheque status</label>
                        <select name="cheque_status" id="cheque_status" class="form-control" required="required" v-model="chequeStatus" data-cheque-status="{{ $invoice->cheque_status }}">
                            <option value="">Select cheque status</option>
                            @foreach (config('constants.cheque_status') as $cheque_status => $display_name)
                                <option value="{{ $cheque_status }}">{{ $display_name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="form-group col-md-2" v-if="paymentType == 'cheque' && chequeStatus == 'received'">
                        <label for="cheque_received_date" class="field-required">Cheque Received Date</label>
                        <input type="text" class="form-control date-field" required="required" name="cheque_received_date" id="cheque_received_date" placeholder="{{ config('constants.finance.input_date_format') }}" value="{{ $invoice->cheque_received_date ? date(config('constants.display_date_format'), strtotime($invoice->cheque_received_date)) : '' }}">
                    </div>
                    <div class="form-group col-md-2" v-if="paymentType == 'cheque' && chequeStatus == 'cleared'">
                        <label for="cheque_cleared_date" class="field-required">Cheque Cleared Date</label>
                        <input type="text" class="form-control date-field" required="required" name="cheque_cleared_date" id="cheque_cleared_date" placeholder="{{ config('constants.finance.input_date_format') }}" value="{{ $invoice->cheque_cleared_date ? date(config('constants.display_date_format'), strtotime($invoice->cheque_cleared_date)) : '' }}">
                    </div>
                    <div class="form-group col-md-2" v-if="paymentType == 'cheque' && chequeStatus == 'bounced'">
                        <label for="cheque_bounced_date" class="field-required">Cheque Bounced Date</label>
                        <input type="text" class="form-control date-field" required="required" name="cheque_bounced_date" id="cheque_bounced_date" placeholder="{{ config('constants.finance.input_date_format') }}" value="{{ $invoice->cheque_bounced_date ? date(config('constants.display_date_format'), strtotime($invoice->cheque_bounced_date)) : '' }}">
                    </div> --}}
                </div>
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
                <div class="form-row mb-4">
                    <div class="form-group col-md-5">
                        <label for="comments">Comments</label>
                        <textarea name="comments" id="comments" rows="5" class="form-control">{{ $invoice->comments }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
