@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'reports'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Reports</h1></div>
        <form action="/finance/reports" method="GET" class="col-md-6 form-inline d-flex justify-content-end">
            <div class="form-group">
                <input type="date" name="start" id="start" placeholder="dd/mm/yyyy" class="form-control form-control-sm" value="{{ $startDate ?? '' }}">
            </div>
            <div class="form-group ml-2">
                <input type="date" name="end" id="end" placeholder="dd/mm/yyyy" class="form-control form-control-sm" value="{{ $endDate ?? '' }}">
            </div>
            <div class="form-group ml-2">
                <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            </div>
        </form>
    </div>
    <br>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-inline">Total invoices sent:&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ $invoices->count() }}</h3></div>
            @if (isset($displayStartDate) && isset($displayEndDate))
                <div class="d-inline">Showing results for&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ $displayStartDate }} – {{ $displayEndDate }}</h3></div>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4>Invoiced amount</h4>
                    @foreach ($report['sentAmount'] as $currency => $sentAmount)
                        <h5><b>{{ $currency }} : </b>{{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $sentAmount }}</h5>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <h4>Received amount</h4>
                    @foreach ($report['paidAmount'] as $currency => $sentAmount)
                        <h5><b>{{ $currency }} : </b>{{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $sentAmount }}</h5>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <h4>Balance left</h4>
                    @foreach ($report['dueAmount'] as $currency => $dueAmount)
                        <h5>
                            <b>{{ $currency }} : </b> {{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $dueAmount }}
                        </h5>
                    @endforeach
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <h4>GST received</h4>
                    <h5>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $report['gst'] }}</h5>
                </div>
                <div class="col-md-6">
                    <h4>TDS deducted</h4>
                    <h5>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $report['tds'] }}</h5>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <h4>Bank charges</h4>
                    @foreach ($report['transactionCharge'] as $currency => $amount)
                        <h5><b>{{ $currency }} : </b> {{ config("constants.currency.$currency.symbol") }}&nbsp;{{ $amount }}</h5>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <h4>Service Tax on Fund Transfer</h4>
                    @foreach ($report['transactionTax'] as $currency => $amount)
                        <h5><b>{{ $currency }} : </b> {{ config("constants.currency.$currency.symbol") }}&nbsp;{{ $amount }}</h5>
                    @endforeach
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Invoice</th>
                                <th>Sent on</th>
                                <th>Invoiced amount</th>
                                <th>GST</th>
                                <th>Received on</th>
                                <th>Received amount</th>
                                <th>TDS deducted</th>
                                <th>Bank Charges</th>
                                <th>ST on Fund Transfer</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>
                                <a href="/finance/invoices/{{ $invoice->id }}/edit" target="_blank">
                                    @foreach ($invoice->projectStageBillings as $billing)
                                        {{ $loop->first ? '' : '|' }}
                                        {{ $billing->projectStage->project->name }}
                                    @endforeach
                                </a>
                                @switch ($invoice->status)
                                    @case('paid')
                                        <span class="badge badge-pill badge-success">
                                        @break
                                    @case('unpaid')
                                        <span class="badge badge-pill badge-danger">
                                        @break
                                @endswitch
                                {{ $invoice->status }}</span>
                            </td>
                            <td>{{ date(config('constants.display_date_format'), strtotime($invoice->sent_on)) }}</td>
                            <td>{{ config('constants.currency.' . $invoice->currency_sent_amount . '.symbol') }}&nbsp;{{ $invoice->sent_amount }}</td>
                            @if ($invoice->currency_sent_amount == 'INR' && $invoice->gst)
                                <td>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $invoice->gst }}</td>
                            @else
                                <td>-</td>
                            @endif
                            @if ($invoice->status == 'paid')
                                <td>{{ date(config('constants.display_date_format'), strtotime($invoice->paid_on)) }}</td>
                                <td>{{ config("constants.currency.$invoice->currency_paid_amount.symbol") }}&nbsp;{{ $invoice->paid_amount }}</td>
                                @if ($invoice->currency_sent_amount == 'INR' && $invoice->tds)
                                    <td>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $invoice->tds }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if ($invoice->transaction_charge)
                                    <td>{{ config("constants.currency.$invoice->currency_transaction_charge.symbol") }}&nbsp;{{ $invoice->transaction_charge }}</td>
                                @else
                                    <td>-</td>
                                @endif
                                @if ($invoice->transaction_tax)
                                    <td>{{ config("constants.currency.$invoice->currency_transaction_tax.symbol") }}&nbsp;{{ $invoice->transaction_tax }}</td>
                                @else
                                    <td>-</td>
                                @endif
                            @else
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            @endif
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
