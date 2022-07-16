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
                    @if($clientCurrency == config('constants.countries.india.currency') || $clientCurrency == null)
                        <th>GST Amount</th>
                        <th>Amount(+GST)</th>
                        <th>TDS</th>
                    @endif
                    @if($clientCurrency != config('constants.countries.india.currency') || $clientCurrency == null)
                        <th>Amount in INR</th>
                    @endif   
                    <th>Amount Recieved</th>
                    @if($clientCurrency != config('constants.countries.india.currency') || $clientCurrency == null)
                        <th>Bank Charges</th>
                        <th>Dollar Rate</th>
                        <th>Exchange Rate differene</th>
                        <th>Amount received in Dollars</th>
                    @endif
                    <th>Sent on Date</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{optional($invoice->project)->name ?: ($invoice->client->name . 'Projects')}}</td>
                        <td>{{$invoice->invoice_number}}</td>
                        <td>{{$invoice->amount}}</td>
                        @if($clientCurrency == config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>{{$invoice->gst}}</td>
                            <td>{{$invoice->total_amount}}</td>
                            <td>{{$invoice->tds}}</td>
                        @endif
                        @if($clientCurrency != config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>{{$invoice->InvoiceAmountInInr}}</td>
                        @endif
                        <td>{{$invoice->amount_paid}}</td>
                        @if($clientCurrency != config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>{{$invoice->bank_charges}}</td>
                            <td>{{$invoice->conversion_rate}}</td>
                            <td>{{$invoice->conversion_rate_diff}}</td>
                            <td>{{$invoice->amount_paid}}</td>
                        @endif
                        <td>{{$invoice->sent_on->format(config('invoice.default-date-format'))}}</td>
                        <td>{{$invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-'}}</td>
                        <td>{{$invoice->status}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td>-</td>
                    <td>-</td>
                    @if(!$invoices->isEmpty())
                        <td>{{$invoices->sum('amount')}}</td>
                        @if($clientCurrency == config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>{{$invoices->sum('gst')}}</td>
                            <td>{{$invoices->sum('total_amount')}}
                            <td>{{$invoices->sum('tds')}}</td>
                        @endif
                        @if($clientCurrency != config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>{{$invoices->sum('InvoiceAmountInInr')}}</td>
                        @endif
                        <td>{{$invoices->sum('amount_paid')}}</td>
                        @if($clientCurrency != config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>{{$invoices->sum('bank_charges')}}</td>
                            <td>{{$invoices->avg('conversion_rate')}}</td>
                            <td>{{$invoices->avg('conversion_rate_diff')}}</td>
                            <td>{{$invoices->sum('amount_paid')}}</td>
                        @endif
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    @else
                        <td>-</td>
                        @if($clientCurrency == config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        @endif
                        @if($clientCurrency != config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>-</td>
                        @endif
                        <td>-</td>
                        @if($clientCurrency != config('constants.countries.india.currency') || $clientCurrency == null)
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        @endif
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