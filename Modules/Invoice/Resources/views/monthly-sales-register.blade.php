@extends('invoice::layouts.master')
@section('content')

<div class="mx-15" id="vueContainer">
    <br>
    <br>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1"> Monthly Sales Register Report</h4>
        <span>
            <a href="{{ route('invoice.msr-report-export', request()->all()) }}" class="btn btn-info text-white"> Export To Excel</a>
        </span>
    </div>
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
                    
                    @if (request()->input('region') == config('invoice.region.indian'))
                        <th>Type (B2B/B2G/B2C)</th>
                        <th>GST NO.</th>
                    @else
                        <th>Type</th>
                    @endif
                    <th>Item Description</th>
                    <th>Units (Hrs.)</th>
                    @if (request()->input('region') == config('invoice.region.indian'))
                        <th>Unit Rate</th>
                        <th>Total taxable</th>
                        <th>IGST Value</th>
                        <th>CGST Value</th>
                        <th>SGST Value</th>
                    @else
                        <th>Rate (FCY)</th>
                        <th>Ex. Rate</th>
                        <th>Total Amont (INR)</th>
                    @endif
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
                        <td>{{ $invoice->created_at->format(config('invoice.default-date-format')) }}</td>
                        <td>{{ $invoice->client->name }}</td>
                        <td>{{ $invoice->client->addresses->first() ? $address->first()->completeAddress :'' }}</td>
                        <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->country_id == 1) ? 'India' : 'Export') : '' }}</td>
                        @if (request()->input('region') == config('invoice.region.indian'))
                            <td>{{ $clientAddress[$key]  ? $clientAddress[$key]->gst_number : 'B2C' }}</td>
                        @endif
                        <td>{{ $invoice->project ? $invoice->project->name : ''}}</td>
                        <td>{{ $invoice->project ? $invoice->project->total_estimated_hours : '' }}</td>
                        <td>{{ optional($invoice->client->billingDetails)->service_rates }}</td>
                        @if (request()->input('region') == config('invoice.region.indian'))
                            <td>{{ $invoice->invoiceAmount() }}</td>
                            <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state != config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 ) ? $igst[$key] : '0') : '' }}</td>
                            <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state == config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 ) ? $cgst[$key] : '0') : '' }}</td>
                            <td>{{ $clientAddress[$key] ? (($clientAddress[$key]->state == config('invoice.invoice-details.billing-state')) && ($clientAddress[$key]->country_id == 1 ) ? $sgst[$key] : '0') : '' }}</td>
                        @else
                            <td>{{ $invoice->conversion_rate }}</td>
                            <td>{{ $invoice->invoiceAmountInInr}}</td>
                        @endif
                        <td>{{ $invoice->totalAmount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $invoices->links() }}
</div>

@endsection