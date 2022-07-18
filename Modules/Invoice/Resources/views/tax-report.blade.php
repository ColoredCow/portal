@extends('invoice::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br>
    <br>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1"> Monthly Tax Report</h4>
        <span>
            <a href="{{ route('invoice.tax-report-export', request()->all()) }}" class="btn btn-info text-white"> Export To Excel</a>
        </span>
    </div>
    <br>
    <br>

    <div>
        @include('invoice::subviews.tax-report.filters')
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="sticky-top">
                    <th></th>
                    <th>Project</th>
                    <th>Amount</th>
                    <th>Received amount</th>
                    @if (request()->input('region') == config('invoice.region.indian'))
                        <th>Amount (+GST)</th>
                        <th>GST</th>
                        <th>TDS</th>
                    @endif
                    @if (request()->input('region') == config('invoice.region.international'))
                        <th>Bank Charges</th>
                        <th>Conversion Rate Difference</th>
                    @endif
                    @if(request()->input('region') == '')
                        <th>Amount (+GST)</th>
                        <th>GST</th>
                        <th>TDS</th>
                        <th>Bank Charges</th>
                        <th>Conversion Rate Difference</th>
                    @endif
                    <th>Sent at</th>
                    <th>Payment at</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                        <td>
                            <a href="{{ route('invoice.edit', $invoice) }}">{{ optional($invoice->project)->name ?: ($invoice->client->name . ' Projects') }}</a>
                        </td>
                        <td>{{ $invoice->display_amount }}</td>
                        <td>{{ $invoice->amount_paid }}</td>
                        @if (request()->input('region') == config('invoice.region.indian'))
                            <td>{{ $invoice->invoiceAmount() }}</td>
                            <td>{{ $invoice->gst }}</td>
                            <td>{{ number_format((float)$invoice->tds, 2) }}</td>
                        @endif
                        @if (request()->input('region') == config('invoice.region.international'))
                            <td>{{ $invoice->bank_charges }}</td>
                            <td>{{ $invoice->conversion_rate_diff }}</td>
                        @endif
                        @if(request()->input('region') == '')
                            <td>{{ $invoice->invoiceAmount() }}</td>
                            <td>{{ $invoice->gst }}</td>
                            <td>{{ number_format((float)$invoice->tds, 2) }}</td>
                            <td>{{ $invoice->bank_charges }}</td>
                            <td>{{ $invoice->conversion_rate_diff }}</td>
                        @endif
                        <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                        <td>{{ $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-'  }}</td>
                        <td class="{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }}">{{ Str::studly($invoice->status) }}</td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection