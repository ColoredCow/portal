@extends('invoice::layouts.master')
@section('content')
    <div class="container" id="vueContainer">
        <br>
        <br>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <ul class="nav nav-pills my-3">
            @php
                $request = request()->all();
            @endphp
            <li class="nav-item mr-3">
                @php
                    $request['invoice_status'] = 'ready';
                @endphp
                <a class="nav-link {{ (request()->input('invoice_status', 'ready') == 'ready') ? 'active' : '' }}" href="{{ route('invoice.index', $request)  }}">Ready to Send</a>
            </li>
            <li class="nav-item mr-2">
                @php
                    $request['invoice_status'] = 'sent';
                @endphp
                <a class="nav-link {{ (request()->input('invoice_status', 'ready') == 'sent') ? 'active' : '' }}" href="{{ route('invoice.index', $request)  }}">Sent</a>
            </li>
        </ul>
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1">Invoices</h4>
            @if (request()->invoice_status == 'sent') 
                <span>
                    <a href="{{ route('invoice.create') }}" class="btn btn-info text-white">Add Invoice</a>
                </span>
            @endif
        </div>
        <br>
        <br>
        @if (request()->invoice_status == 'sent')
            <div>
                @include('invoice::index-filters')
            </div>
        @endif

        <div class="text-danger mt-2">
            @error('invoice_email')
                {{ $message }}
            @enderror
        </div>
        
            <div class="font-muli-bold my-4">
                Current Exchange rates ($1) : &nbsp; ₹{{ $currencyService->getCurrentRatesInINR() }}
            </div>
        @if(request()->invoice_status == 'sent')
            <div class="font-muli-bold my-4">
                Receivable amount (for current filters): &nbsp; ₹{{ $totalReceivableAmount }}
            </div>
        @endif
        <div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Project</th>
                        <th>Invoice Number</th>
                        <th>Amount ( + taxes)</th>
                        @if (request()->invoice_status == "sent")
                            <th>Sent on</th>
                            <th>Due on</th>
                            <th>Paid on</th>
                            <th>Status</th>
                        @elseif (request()->invoice_status == "ready")
                            <th>Preview Invoice</th>
                            <th>Preview Mail</th>
                            <th>Action</th>
                        @endif
                        @if (request()->input('status') == 'sent' || request()->input('status') == '')
                            <th class="d-none">Email</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if((request()->invoice_status == 'sent'))
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('invoice.edit', $invoice) }}">{{ $invoice->project->name }}</a>
                                </td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->invoiceAmount() }}</td>
                                <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                                <td class='{{ $invoice->shouldHighlighted() ? 'font-weight-bold text-danger ' : '' }}'>
                                    {{ $invoice->receivable_date->format(config('invoice.default-date-format')) }}
                                </td>
                                <td class="{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }}">
                                    {{ $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '' }}
                                </td>
                                <td class="{{ $invoice->shouldHighlighted() ? 'font-weight-bold text-danger' : '' }}{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }}">
                                    {{ $invoice->shouldHighlighted() ? __('Overdue') : $invoice->status }}
                                </td>
                                @if (Str::studly($invoice->status) == 'Sent')
                                    <td class="d-none" ><button type="button" class="btn btn-primary ml-auto" data-bs-toggle="modal"
                                            data-bs-target="#Modal">Send Mail</button>
                                        <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4> Pending Invoice Mail</h4>
                                                        <button type="button" class="btn-close ml-auto" data-bs-dismiss="modal"
                                                            aria-label="Close">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('invoice.sendEmail', $invoice) }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="month" value="{{ $filters['month'] }}">
                                                            <input type="hidden" name="year" value="{{ $filters['year'] }}">
                                                            <label for="sender_invoice_email">Sender's email adress</label>
                                                            <input type="email" class="form-control mt-2"
                                                                name="sender_invoice_email" id="sender_invoice_email"
                                                                value="{{ config('invoice.pending-invoice-mail.pending-invoice.email') }}">
                                                            <label for="invoice_email" class="mt-4">CC Email</label>
                                                            <input type="email" multiple class="form-control mt-2"
                                                                name="invoice_email" id="invoice_email" placeholder="CC Email"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Please enter comma separated emails">
                                                            <button type="submit" class="btn btn-primary mt-4">Send</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>
@endsection
