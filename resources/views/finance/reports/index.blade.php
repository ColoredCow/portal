@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'reports'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Reports</h1></div>
        <div class="col-md-6 d-flex align-items-center justify-content-end">
            {{-- range --}}
        </div>
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
                            <a href="/finance/invoices/{{ $invoice->id }}/edit" target="_blank">Invoice ID {{ $invoice->id }}</a>
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
                            $dueAmount = $sentAmount - $report['paidAmount'][$currency];
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
