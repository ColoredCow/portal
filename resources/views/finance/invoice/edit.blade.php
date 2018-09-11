@extends('layouts.app')

@section('content')
<div class="container" id="form_invoice">
    <br>
    @include('finance.menu', ['active' => 'invoices'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Edit Invoice</h1></div>
        <div class="col-md-6"><a href="/finance/invoices/create" class="btn btn-success float-right">Create Invoice</a></div>
    </div>
    @include('status', ['errors' => $errors->all()])
    <div class="card">
        <form action="/finance/invoices/{{ $invoice->id }}" method="POST" enctype="multipart/form-data" class="form-invoice">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="card-header">
                <h5>Invoice Details</h5>
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
                                <select name="invoice_currency" id="invoice_currency" class="btn btn-secondary" required="required" v-model="invoiceCurrency" data-invoice-currency="{{ $invoice->currency }}">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    <option value="{{ $currency }}">{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="invoice_amount" id="invoice_amount" placeholder="Invoice Amount" required="required" step=".01" min="0" v-model="sentAmount" data-sent-amount="{{ $invoice->amount }}">
                        </div>
                    </div>
                    <div class="form-group col-md-3" v-if="invoiceCurrency == 'INR'">
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
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="due_on">Due date</label>
                        <input type="date" class="form-control" name="due_on" id="due_on" placeholder="{{ config('constants.finance.input_date_format') }}" value="{{ $invoice->due_on }}">
                    </div>
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
    <a href="#" class="btn btn-secondary mt-3 px-3">Add payment</a>
</div>
@endsection
