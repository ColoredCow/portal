@extends('invoice::layouts.master')
@section('content')

<div class="mx-15" id="vueContainer">
    <br>
    <br>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">Monthly GST Report</h4>
        <span>
            <a href="{{ route('invoice.monthly-tax-report-export', request()->all()) }}" class="btn btn-info text-white">Export To Excel</a>
        </span>
    </div>
    <br>
    <br>

    <div>
        @include('invoice::subviews.gst-report.filters')
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th></th>
                    <th>Date</th>
                    <th>Particular</th>
                    <th>Type</th>
                    <th>Invoice No.</th>
                    <th>GST NO.</th>
                    <th>Invoice Value</th>
                    <th>Rate</th>
                    <th>Receivable Amount</th>
                    <th>Taxable Amount</th>
                    <th>IGST</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>HSN Code</th>
                </tr>
            </thead>

            <tbody>
                @foreach($invoices as $key => $invoice)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                    <td>{{ $invoice->client->name }}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->country_id == 1) ? 'India' : 'Export') : '' }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->country_id == 1 ) ? (isset($clientAddress[$key]->gst_number)  ? $clientAddress[$key]->gst_number : 'B2C') : 'Export') : '' }}</td>
                    <td>{{ $invoice->invoiceAmount() }}</td>
                    <td></td>
                    <td>{{ $clientAddress[$key] ? $invoice->invoiceAmount() : '' }}</td>
                    <td>{{ $invoice->display_amount }}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state != config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 )  ? $igst[$key] : '0') : ''}}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state == config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 ) ? $cgst[$key] : '0') : '' }}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state == config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 ) ? $sgst[$key] : '0') : '' }}</td>
                    <td>{{-- HSN CODE --}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {!! $invoices->links() !!}
</div>

@endsection