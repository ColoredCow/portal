@extends('invoice::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br>
    <br>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1"> Invoices</h4>
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
            @if (request()->input('region') == 'indian' )
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Project</th>
                        <th>Amount</th>
                        <th>GST</th>
                        <th>Amount (+GST)</th>
                        <th>Received amount</th>
                        <th>TDS</th>
                        <th>Sent at</th>
                        <th>Payment at</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('invoice.edit', $invoice) }}">{{ $invoice->project->name }}</a>
                        </td>
                        <td>{{ $invoice->display_amount }}</td>
                        <td>{{ $invoice->gst }}</td>
                        <td>{{ $invoice->invoiceAmount() }}</td>
                        <td>{{ $invoice->amount_paid }}</td>
                        <td>{!! number_format((float)($invoice->tds), 2) !!}</td>
                        <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                        <td>{{ $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-'  }}</td>
                        @if($invoice->status == 'paid')
                            <td><p class="text-success">{{ Str::studly($invoice->status) }}</p></td>
                        @else
                            <td> {{ Str::studly($invoice->status) }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            @endif
            @if(request()->input('region') == 'international')
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Project</th>
                        <th>Amount</th>
                        <th>Received amount $</th>
                        <th>Bank Charges</th>
                        <th>Conversion Rate Diff</th>
                        <th>Sent at</th>
                        <th>Payment at</th>
                        <th>Status</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('invoice.edit', $invoice) }}">{{ $invoice->project->name }}</a>
                        </td>
                        <td>{{ $invoice->display_amount }}</td>
                        <td>{{ $invoice->amount_paid }}</td>
                        <td>{{ $invoice->bank_charges }}</td>
                        <td>{{ $invoice->conversion_rate_diff }}</td>
                        <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                        <td>{{ $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-'  }}</td>
                        @if($invoice->status == 'paid')
                            <td><b><p class="text-success">{{ Str::studly($invoice->status) }}</p></b></td>
                        @else
                            <td> {{ Str::studly($invoice->status) }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            @endif 
            @if(request()->input('region') == '')
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Project</th>
                        <th>Amount</th>
                        <th>GST</th>
                        <th>Amount (+GST)</th>
                        <th>Received amount</th>
                        <th>Bank Charges</th>
                        <th>Conversion Rate Diff</th>
                        <th>TDS</th>
                        <th>Sent at</th>
                        <th>Payment at</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('invoice.edit', $invoice) }}">{{ $invoice->project->name }}</a>
                        </td>
                        <td>{{ $invoice->display_amount }}</td>
                        <td>{{ $invoice->gst }}</td>
                        <td>{{ $invoice->invoiceAmount() }}</td>
                        <td>{{ $invoice->amount_paid }}</td>
                        <td>{{ $invoice->bank_charges }}</td>
                        <td>{{ $invoice->conversion_rate_diff }}</td>
                        <td>{!! number_format((float)($invoice->tds), 2) !!}</td>
                        <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                        <td>{{ $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '-'  }}</td>
                        @if($invoice->status == 'paid')
                            <td><b><p class="text-success">{{ Str::studly($invoice->status) }}</p></b></td>
                        @else
                            <td> {{ Str::studly($invoice->status) }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            @endif   
        </table>
    </div>

</div>

@endsection