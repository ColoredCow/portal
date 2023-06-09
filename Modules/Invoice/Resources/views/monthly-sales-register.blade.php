@extends('invoice::layouts.master')
@section('content')

<div class="mx-15" id="vueContainer">
    <br>
    <br>

    {{-- <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">Monthly GST Report</h4>
        <span>
            <a href="{{ route('invoice.monthly-tax-report-export', request()->all()) }}" class="btn btn-info text-white">Export To Excel</a>
        </span>
    </div> --}}
    <br>
    <br>

    <div>
        @include('invoice::subviews.monthly-sales-register-report.filter')
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th></th>
                    <th>Invoice No.</th>
                    <th>Invoice Date</th>
                    <th>Client Name</th>
                    <th>Client complete Address</th>
                    <th>Type</th>
                    <th>GST NO.</th>
                    <th>Invoice Value</th>
                    <th>Rate</th>
                    <th>Receivable Amount</th>
                    <th>Total Taxable</th>
                    <th>IGST Value</th>
                    <th>CGST Value</th>
                    <th>SGST Value</th>
                    <th>Net Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($invoices as $key => $invoice)

                @php
                    $address = $invoice->client->addresses;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                    <td>{{ $invoice->client->name }}</td>
                    <td>{{ $invoice->client->addresses->first() ? $address->first()->completeAddress :''}}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->country_id == 1) ? 'India' : 'Export') : '' }}</td>
                    <td>{{ $clientAddress[$key] ? $clientAddress[$key]->gst_number : '' }}</td>
                    <td>{{ $invoice->invoiceAmount() }}</td>
                    @dd($invoice->currentRates)
                    <td>{{ $invoice->currentRates}}</td>
                    <td>{{ $clientAddress[$key] ? $invoice->invoiceAmount() : '' }}</td>
                    <td>{{ $invoice->display_amount }}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state != config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 ) ? $igst[$key] : '0') : '' }}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state == config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 ) ? $cgst[$key] : '0') : '' }}</td>
                    <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state == config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 ) ? $sgst[$key] : '0') : '' }}</td>
                    <td>{{-- HSN CODE --}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection