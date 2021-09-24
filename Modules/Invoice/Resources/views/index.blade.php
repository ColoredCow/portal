@extends('invoice::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br>
    <br>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1"> Invoices</h4>
        <span>
            <a href="{{ route('invoice.create') }}" class="btn btn-info text-white"> Add new invoice</a>
        </span>
    </div>
    <br>
    <br>

    <div>
        @include('invoice::index-filters')
    </div>

    <div class="font-muli-bold my-4">
        Current Exchange rates (1 USD) : &nbsp;  {{  $currencyService->getCurrentRatesInINR() }} INR
    </div>

    <div class="font-muli-bold my-4">
        Receivable amount (for current filters): &nbsp; {{ $totalReceivableAmount }} INR
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th>Project</th>
                    <th>Amount ( + taxes)</th>
                    <th>Sent on</th>
                    <th>Receivable date</th>
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
                    <td>{{ $invoice->invoiceAmount() }}</td>
                    <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                    <td class = '{{ $invoice->shouldHighlighted() ? 'font-weight-bold text-danger ' : ''}}'>
                        {{ $invoice->receivable_date->format(config('invoice.default-date-format'))  }}
                    </td>
                    <td class="{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }}">{{ Str::studly($invoice->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection