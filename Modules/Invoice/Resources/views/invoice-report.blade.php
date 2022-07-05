@extends('invoice::layouts.master')
@section('content')

<div class="mx-15">
    <br>
    <br>
    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1">Yearly Invoice Report</h4>
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
                    <th>Sent on Date</th>
                    <th>Payment Date</th>
                    <th>Invoice Amount</th>
                    <th>GST Amount</th>
                    <th>TDS</th>
                    <th>Amount in INR</th>
                    <th>Amount Recieved</th>
                    <th>Bank Charges</th>
                    <th>Dollar Rate</th>
                    <th>Exchange Rate differene</th>
                    <th>Amount received in Dollars</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{optional($invoice->project)->name ?: ($invoice->client->name . 'Projects')}}</td>
                        <td>{{$invoice->invoice_number}}</td>
                        <td>{{$invoice->sent_on->format(config('invoice.default-date-format'))}}</td>
                        <td>{{$invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-'}}</td>
                        <td>{{$invoice->amount}}</td>
                        @if($invoice->currency == config('constants.countries.india.currency'))
                            <td>{{$invoice->gst}}</td>
                            <td>{{$invoice->tds}}</td>
                            <td>{{$invoice->InvoiceAmountInInr}}</td>
                            <td>{{$invoice->amount_paid}}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        @else
                            <td>-</td>
                            <td>-</td>
                            <td>{{$invoice->InvoiceAmountInInr}}</td>
                            <td>{{$invoice->amount_paid}}</td>
                            <td>{{$invoice->bank_charges}}</td>
                            <td>{{$invoice->conversion_rate}}</td>
                            <td>{{$invoice->conversion_rate_diff}}</td>
                            <td>{{$invoice->amount_paid}}</td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    @if(!$invoices->isEmpty())
                        <td>{{$invoices->sum('amount')}}</td>
                        <td>{{$invoices->sum('gst')}}</td>
                        <td>{{$invoices->sum('tds')}}</td>
                        <td>{{$invoices->sum('InvoiceAmountInInr')}}</td>
                        <td>{{$invoices->sum('amount_paid')}}</td>
                        <td>{{$invoices->sum('bank_charges')}}</td>
                        <td>{{$invoices->sum('conversion_rate')}}</td>
                        <td>{{$invoices->sum('conversion_rate_diff')}}</td>
                        <td>{{$invoices->avg('amount_paid')}}</td>
                    @else
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection