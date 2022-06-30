@extends('invoice::layouts.master')
@section('content')

<div class="mx-15">
    <br>
    <br>
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">Yearly Invoice Report</h4>
        <span>
            <a href="{{ route('invoice.yearly-report-export', request()->all()) }}" class="btn btn-info text-white"> Export To Excel</a>
        </span>
    </div>
    <br>
    <br>
    <div>
        @include('invoice::subviews.invoice-report.filters')
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>S.N</th>
                    <th>Project Name</th>
                    <th>Invoice Number</th>
                    <th>Invoice Amount</th>
                    <th>GST Amount</th>
                    <th>TDS</th>
                    <th>Bank Charges</th>
                    <th>Dollar Rate</th>
                    <th>Exchange Rate differene</th>
                    <th>Amount received in Dollars</th>
                    <th>Amount in INR</th>
                    <th>Sent on Date</th>
                    <th>Payment Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$invoice->project->name}}</td>
                    <td>{{$invoice->invoice_number}}</td>
                    <td>{{$invoice->amount}}</td>
                    @if($invoice->currency == "INR")
                        <td>{{$invoice->gst}}</td>
                        <td>{{$invoice->tds}}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    @else
                        <td>-</td>
                        <td>-</td>
                        <td>{{$invoice->bank_charges}}</td>
                        <td>{{$invoice->conversion_rate}}</td>
                        <td>{{$invoice->conversion_rate_diff}}</td>
                        <td>{{$invoice->amount}}</td>
                    @endif
                    <td>{{$invoice->InvoiceAmountInInr}}</td>
                    <td>{{$invoice->sent_on->format(config('invoice.default-date-format'))}}</td>
                    <td>{{ $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-'  }}</td>
                </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection