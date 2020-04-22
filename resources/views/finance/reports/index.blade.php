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
                <input type="hidden" name="type" value="dates">
                <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
            </div>
        </form>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-column flex-md-row justify-content-between">
                <div class="d-flex">
                    <div class="mr-5">Invoices sent:&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ sizeof($sentInvoices) }}</div>
                    <div class="mr-5">Invoices received:&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ sizeof($paidInvoices) }}</div>
                    <div>Payments:&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ $report['totalPayments'] }}</div>
                </div>
                <div>
                    @if ($showingResultsFor)
                        Showing results for&nbsp;&nbsp;<h3 class="d-inline mb-0">{{ $showingResultsFor }}</h3>
                        @if (isset($monthsList))
                        <div class="btn-group">
                            <button type="button" class="btn btn-light btn-lg px-1 py-0 dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                @foreach ($monthsList as $month)
                                <a class="dropdown-item" href="/finance/reports?type=monthly&year={{ $month['year'] }}&month={{ $month['id'] }}">{{ $month['name'] }}&nbsp;{{ $month['year'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4>Invoiced amount</h4>
                    @foreach ($report['sentAmount'] as $currency => $sentAmount)
                        <h5 id="sent_amount_{{ $currency }}" data-sent-amount="{{ $sentAmount }}"><b>{{ $currency }} : </b>{{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $sentAmount }}</h5>
                        @if($currency == 'USD')
                            <h6>Est rate USD to INR:&nbsp;<input type="number" class="form-control form-control-sm d-inline w-25p" placeholder="rate" v-model="conversionRateUSD" id="conversion_rate_usd" min="0" step="0.01" data-conversion-rate-usd="{{ config('constants.finance.conversion-rate-usd-to-inr') }}"></h6>
                            <h6>Est amount USD to INR:&nbsp;{{ config('constants.currency.INR.symbol') }}&nbsp;<span>@{{ convertedUSDSentAmount }}</span></h6>
                        @endif
                    @endforeach
                    <br>
                    <h5>Total INR estimated: {{ config('constants.currency.INR.symbol') }} @{{ totalINREstimated }}</h5>
                </div>
                <div class="col-md-3">
                    <h4>Receivable</h4>
                    @foreach ($report['receivable'] as $currency => $receivable)
                        <h5 id="sent_amount_{{ $currency }}" data-sent-amount="{{ $receivable }}"><b>{{ $currency }} : </b>{{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $receivable }}</h5>
                    @endforeach
                    {{-- <h4 class="mt-3">Total Receivable</h4>
                    @foreach ($totalReceivables as $currency => $totalReceivable)
                        <h5 id="sent_amount_{{ $currency }}" data-sent-amount="{{ $totalReceivable }}"><b>{{ $currency }} : </b>{{ config('constants.currency.' . $currency . '.symbol') }}&nbsp;{{ $totalReceivable }}</h5>
                    @endforeach --}}
                </div>
                <div class="col-md-3">
                    <h4>Received amount</h4>
                    <h5>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $report['totalPaidAmount'] }}</h5>
                </div>
                <div class="col-md-2">
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
                    @foreach ($report['bankCharges'] as $currency => $amount)
                        <h5><b>{{ $currency }} : </b> {{ config("constants.currency.$currency.symbol") }}&nbsp;{{ $amount }}</h5>
                    @endforeach
                </div>
                <div class="col-md-4">
                    <h4>Service Tax on Forex</h4>
                    <h5><b>{{ $currency }} : </b> {{ config("constants.currency.INR.symbol") }}&nbsp;{{$report['bankServiceTaxForex']}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header">
            <h4 class="m-0">Payments received</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Sent on</th>
                        <th>Invoiced amount</th>
                        <th>GST</th>
                        <th>Received on</th>
                        <th>Received amount</th>
                        <th>TDS</th>
                        <th>Bank charges</th>
                        <th>ST on Forex</th>
                        {{-- <th>Balance left</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($paidInvoices as $invoice)
                        @foreach($invoice->payments as $payment)
                            <tr>
                                <td>
                                    <a href="{{ route('invoices.edit', $invoice) }}" target="_blank">
                                        @foreach ($invoice->projectStageBillings as $billing)
                                            {{ $loop->first ? '' : '|' }}
                                            {{ $billing->projectStage->project->name }}
                                        @endforeach
                                    </a>
                                    <span>
                                        <a href="/finance/invoices/download/{{ $invoice->file_path }}"><i class="fa fa-file fa-lg text-primary btn-file ml-2"></i></a>
                                    </span>
                                    <div>{{ $invoice->client->name }}</div>
                                    @if ($invoice->client->country == 'india' && $invoice->client->gst_num)
                                        <div><b>GST:&nbsp;</b>{{ $invoice->client->gst_num }}</div>
                                    @endif
                                </td>
                                <td>{{ date(config('constants.display_date_format'), strtotime($invoice->sent_on)) }}</td>
                                <td>{{ config('constants.currency.' . $invoice->currency . '.symbol') }}&nbsp;{{ $invoice->amount }}</td>
                                @if ($invoice->currency == 'INR' && $invoice->gst)
                                    <td>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $invoice->gst }}</td>
                                @else
                                    <td>–</td>
                                @endif
                                <td>{{ date(config('constants.display_date_format'), strtotime($payment->paid_at)) }}</td>
                                <td>
                                    @php
                                        $type = $payment->currency != 'INR' ? 'converted' : 'default';
                                        $paidAmount = $report['paidAmount'][$payment->currency][$type];
                                    @endphp
                                    {{ config("constants.currency.$payment->currency.symbol") }}&nbsp;{{ number_format((float)$paidAmount, 2, '.', '') }}
                                </td>
                                @if ($payment->currency == 'INR' && $payment->tds)
                                    <td>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $payment->tds }}</td>
                                @else
                                    <td>–</td>
                                @endif
                                @if ($payment->bank_charges)
                                    <td>{{ config("constants.currency.$payment->currency.symbol") }}&nbsp;{{ $payment->bank_charges }}</td>
                                @else
                                    <td>–</td>
                                @endif
                                @if ($payment->bank_service_tax_forex)
                                    <td>{{ config("constants.currency.INR.symbol") }}&nbsp;{{ $payment->bank_service_tax_forex }}</td>
                                @else
                                    <td>–</td>
                                @endif
                                {{-- @if ($invoice->due_amount)
                                    <td>{{ config("constants.currency.$invoice->currency_due_amount.symbol") }}&nbsp;{{ $invoice->due_amount }}</td>
                                @else
                                    <td>–</td>
                                @endif --}}
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header">
            <h4 class="m-0">Invoices sent</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Sent on</th>
                        <th>Invoiced amount</th>
                        <th>GST</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sentInvoices as $invoice)
                        <tr>
                            <td>
                                <a href="{{ route('invoices.edit', $invoice) }}" target="_blank">
                                    @foreach ($invoice->projectStageBillings as $billing)
                                        {{ $loop->first ? '' : '|' }}
                                        {{ $billing->projectStage->project->name }}
                                    @endforeach
                                </a>
                                <span>
                                    <a href="/finance/invoices/download/{{ $invoice->file_path }}"><i class="fa fa-file fa-lg text-primary btn-file ml-2"></i></a>
                                </span>
                                <div>{{ $invoice->client->name }}</div>
                                @if ($invoice->client->country == 'india' && $invoice->client->gst_num)
                                    <div><b>GST:&nbsp;</b>{{ $invoice->client->gst_num }}</div>
                                @endif
                            </td>
                            <td>{{ $invoice->sent_on->format(config('constants.display_date_format')) }}</td>
                            <td>{{ config("constants.currency.$invoice->currency.symbol") }}&nbsp;{{ $invoice->amount }}</td>
                            @if ($invoice->currency == 'INR' && $invoice->gst)
                                <td>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $invoice->gst }}</td>
                            @else
                                <td>–</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
