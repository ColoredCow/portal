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
        <div class="card-header">
            Total invoices sent:&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ $invoices->count() }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Invoices sent</h4>
                    <ul>
                    @foreach($invoices as $invoice)
                        <li>
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
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <h4>Amount invoiced</h4>
                    @foreach ($report['sentAmount'] as $currency => $sentAmount)
                        @if ($sentAmount)
                            <h5><b>{{ $currency }} : </b>{{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $sentAmount }}</h5>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-6">
                    <h4>GST paid</h4>
                    <h5>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $report['gst'] }}</h5>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <h4>Paid amount</h4>
                    @foreach ($report['paidAmount'] as $currency => $sentAmount)
                        @if ($sentAmount)
                            <h5><b>{{ $currency }} : </b>{{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $sentAmount }}</h5>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-6">
                    <h4>TDS paid</h4>
                    <h5>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $report['tds'] }}</h5>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <h4>Due amount</h4>
                    @foreach ($report['sentAmount'] as $currency => $sentAmount)
                        @php
                            if (isset($report['paidAmount'][$currency])) {
                                if ($currency == 'INR') {
                                    $dueAmount = $sentAmount - $report['paidAmount'][$currency] - $report['tds'];
                                } else {
                                    $dueAmount = $sentAmount - $report['paidAmount'][$currency];
                                }
                            }
                        @endphp
                        @if ($dueAmount)
                            <h5>
                                <b>{{ $currency }} : </b>
                                {{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $dueAmount }}
                            </h5>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
