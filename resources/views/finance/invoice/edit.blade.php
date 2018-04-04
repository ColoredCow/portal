@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Edit Invoice</h1>
    <br>
    <a class="btn btn-info" href="/finance/invoices">See all invoices</a>
    <br><br>
    <div class="card">
        <form action="/finance/invoices/{{ $invoice->id }}" method="POST" enctype="multipart/form-data">

            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="card-header">
                <span>Invoices Details</span>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="project_id">Project</label>
                        <select name="project_id" id="project_id" class="form-control" required="required">
                            @foreach ($projects as $project)
                                @php
                                    $selected = $project->id === $invoice->project_id ? 'selected="selected"' : '';
                                @endphp
                                <option value="{{ $project->id }}" {{ $selected }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="project_invoice_id">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required" value="{{ $invoice->project_invoice_id }}">
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="name">Status</label>
                        <select name="status" id="status" class="form-control" required="required">
                        @foreach (config('constants.finance.invoice.status') as $status => $display_name)
                            @php
                                $selected = $status === $invoice->status ? 'selected="selected"' : '';
                            @endphp
                            <option value="{{ $status }}" {{ $selected }}>{{ $display_name }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="sent_on">Sent on</label>
                        <input type="text" class="form-control date-field" name="sent_on" id="sent_on" placeholder="dd/mm/yyyy" required="required" value="{{ date(config('constants.display_date_format'), strtotime($invoice->sent_on)) }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="sent_amount">Invoice amount</label>
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
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="paid_on">Paid on</label>
                        @php
                            $paid_on = $invoice->paid_on ? date(config('constants.display_date_format'), strtotime($invoice->paid_on)) : $invoice->paid_on;
                        @endphp
                        <input type="text" class="form-control date-field" name="paid_on" id="paid_on" placeholder="dd/mm/yyyy" value="{{ $paid_on }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="paid_amount">Received amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="currency_paid_amount" id="currency_paid_amount" class="btn btn-secondary" required="required">
                                @foreach (config('constants.currency') as $currency => $currencyMeta)
                                    @php
                                        $selected = $currency === $invoice->currency_paid_amount ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $currency }}" {{ $selected }}>{{ $currency }}</option>
                                @endforeach
                                </select>
                            </div>
                            <input type="number" class="form-control" name="paid_amount" id="paid_amount" placeholder="Received Amount" step=".01" min="0" value="{{ $invoice->paid_amount }}">
                        </div>
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
                        <label for="invoice_file">Upload Invoice</label>
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
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
