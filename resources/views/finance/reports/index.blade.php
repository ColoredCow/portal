@extends('layouts.app')

@section('content')
<div class="container" id="finance_report">
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
            <div class="d-inline">Total invoices sent:&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ sizeof($sentInvoices) }}</h3></div>
            <div class="d-inline">Total invoices received:&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ sizeof($paidInvoices) }}</h3></div>
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
                    <h5>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $report['totalPaidAmount'] }}</h5>
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
                    <h4>Bank charges on Fund Transfer</h4>
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
            <ul class="nav nav-tabs mt-5">
                <li class="nav-item">
                    <span class="c-pointer nav-link" :class="[showReportTable == 'received' ? 'active' : '']"  @click="showReportTable = 'received'">Received Invoices</span>
                </li>
                <li class="nav-item">
                    <span class="c-pointer nav-link" :class="[showReportTable == 'sent' ? 'active' : '']" @click="showReportTable = 'sent'">Sent Invoices</span>
                </li>
            </ul>
            @include('finance.reports.report-table', ['invoices' => $paidInvoices, 'type' => 'received'])
            @include('finance.reports.report-table', ['invoices' => $sentInvoices, 'type' => 'sent'])
        </div>
    </div>
</div>
@endsection
