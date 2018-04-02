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
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Invoice Title" required="required" value="{{ $invoice->name }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
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
                </div>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="project_invoice_id">Invoice ID</label>
                        <input type="text" class="form-control" name="project_invoice_id" id="project_invoice_id" placeholder="Invoice ID" required="required" value="{{ $invoice->project_invoice_id }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
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
                        <input type="date" class="form-control" name="sent_on" id="sent_on" placeholder="dd/mm/yyyy" required="required" value="{{ date('Y-m-d', strtotime($invoice->sent_on)) }}">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="paid_on">Paid on</label>
                        @php
                            $paid_on = $invoice->paid_on ? date('Y-m-d', strtotime($invoice->paid_on)) : $invoice->paid_on;
                        @endphp
                        <input type="date" class="form-control" name="paid_on" id="paid_on" placeholder="dd/mm/yyyy" value="{{ $paid_on }}">
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
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
