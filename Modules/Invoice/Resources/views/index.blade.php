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
        <ul class="nav nav-pills mb-6">
            @php
                $request = request()->all();
            @endphp
            <li class="nav-item mr-2">
                @php
                    $request['invoice_status'] = 'ready';
                @endphp
                <a class="nav-link {{ (request()->input('invoice_status', 'sent') == 'ready') ? 'active' : '' }}" href="{{ route('invoice.index', $request) }}">Ready to Send</a>
            </li>
            <li class="nav-item mr-2">
                @php
                    $request['invoice_status'] = 'sent';
                @endphp
                <a class="nav-link {{ (request()->input('invoice_status', 'sent') == 'sent') ? 'active' : '' }}" href="{{ route('invoice.index', $request) }}">Sent</a>
            </li>
        </ul>
        <div class="d-flex justify-content-between mb-2">
            <h4 class="mb-1 pb-1 fz-28">Invoices</h4>
            <span>
                <a href="{{ route('invoice.create') }}" class="btn btn-info text-white">Add Invoice</a>
            </span>
        </div>
        <br>
        @if (request()->invoice_status == 'sent' || $invoiceStatus == 'sent')
            <div>
                @include('invoice::index-filters')
            </div>
        @endif
        @error('invoice_email')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
        @enderror
        <div class="font-muli-bold my-4">
            Current Exchange rates ($1) : &nbsp; ₹{{ $currencyService->getCurrentRatesInINR() }}
        </div>
        @if(request()->invoice_status == 'sent' || $invoiceStatus == 'sent')
            <div class="font-muli-bold my-4">
                Receivable amount (for current filters): &nbsp; ₹{{ $totalReceivableAmount }}
            </div>
        @endif
        <div>
            @php
                $month = now(config('constants.timezone.indian'))->subMonth()->format('m');
                $year = now(config('constants.timezone.indian'))->subMonth()->format('Y');
            @endphp
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Project</th>
                        @if (request()->invoice_status == "sent" || $invoiceStatus == 'sent')
                            <th>Invoice Number</th>
                        @else
                        <th>Rates</th>
                        <th>Billable Hours</th>
                        @endif
                        <th>Amount ( + taxes)</th>
                        @if (request()->invoice_status == "sent" || $invoiceStatus == 'sent')
                            <th>Sent on</th>
                            <th>Due on</th>
                            <th>Paid on</th>
                            <th>Status</th>
                        @elseif (request()->invoice_status == "ready")
                            <th>EffortSheet</th>
                            <th>Preview Invoice</th>
                            <th>Action</th>
                        @endif
                        @if (request()->input('status') == 'sent' || request()->input('status') == '')
                            <th class="d-none">Email</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if((request()->invoice_status == 'sent' || $invoiceStatus == 'sent') && $invoices->isNotEmpty())
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('invoice.edit', $invoice) }}">{{ optional($invoice->project)->name ?: ($invoice->client->name . ' Projects') }}</a>
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
                    @elseif((request()->invoice_status == 'ready'  || $invoiceStatus == 'ready') && $clientsReadyToSendInvoicesData->isNotEmpty())
                        @foreach ($clientsReadyToSendInvoicesData as $client)
                            @php
                                $amount = config('constants.currency.' . $client->currency . '.symbol') . $client->getTotalPayableAmountForTerm($month, $year, $client->clientLevelBillingProjects);
                                $invoiceData = [
                                    'projectName' => $client->name . ' Projects',
                                    'billingPersonName' => optional($client->billing_contact)->name,
                                    'billingPersonEmail' => optional($client->billing_contact)->email,
                                    'senderEmail' => config('invoice.mail.send-invoice.email'),
                                    'invoiceNumber' => str_replace('-', '', $client->next_invoice_number),
                                    'totalAmount' => $amount,
                                    'monthName' => date('F', mktime(0, 0, 0, $month, 10)),
                                    'year' => $year,
                                    'emailSubject' => $emailSubject,
                                    'emailBody' => $emailBody,
                                    'clientId' => $client->id
                                ];
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $client->name . ' Projects' }}
                                </td>
                                <td>{{ config('constants.currency.' . $client->currency . '.symbol') . '' . $client->billingDetails->service_rates . __('/hour')}}</td>
                                <td>{{ $client->getClientLevelProjectsBillableHoursForTerm($month, $year) }}</td>
                                <td>{{ $amount }}</td>
                                <td align="center"> <a class="btn btn-sm btn-info text-light" href="{{ $client->effort_sheet_url }}" target="_blank">{{ __('Link') }}</a></td>
                                <td class="text-center">
                                    <form action="{{ route('invoice.generate-invoice-for-client') }}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name='client_id' value="{{ $client->id }}">
                                        <input type='submit' class="btn btn-sm btn-info text-light" value="Preview">
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="btn btn-sm btn-success text-light" id="showPreview" data-invoice-data="{{ json_encode($invoiceData) }}">{{ __('View Mail') }}</div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan=9 class="text-center fz-24 text-theme-gray py-6">No invoices available</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @if(request()->invoice_status == 'ready' || $invoiceStatus == 'ready')
        <div class="modal fade" id="emailPreview" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-block">
                            <h4 class="modal-title">Invoice mail preview </h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('invoice.send-invoice-mail') }}" method="POST" id="sendInvoiceForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="leading-none" for="sendFrom">From</label>
                                    <input type="email" name="from" id="sendFrom"
                                        class="form-control" value="{{ config('invoice.mail.send-invoice.email') }}" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="leading-none" for="sendTo">To</label>
                                    <input type="email" name="to" id="sendTo"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="leading-none" for="sendToName">Receiver Name</label>
                                    <input type="text" name="to_name" id="sendToName"
                                        class="form-control" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="leading-none" for="cc">
                                        CC 
                                        <span data-toggle="tooltip" data-placement="right" title="Comma separated emails">
                                            <i class="fa fa-question-circle"></i>
                                        </span>
                                    </label>
                                    <input type="text" name="cc" id="cc" class="form-control" value="{{ config('invoice.mail.send-invoice.email') }}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="leading-none" for="emailSubject">Subject</label>
                                    <input type="text" name="email_subject" id="emailSubject"
                                        class="form-control" value="{{ $emailSubject }}" required>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="leading-none" for="emailBody">Body</label>
                                    <textarea name="email_body" id="emailBody" class="form-control richeditor">{{ $emailBody }}</textarea>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="form-group ml-1">
                                    <input type="checkbox" id="verifyInvoice" class="c-pointer"> 
                                    <label for="verifyInvoice" class="c-pointer">{{ __("I've verified the Invoice data.") }}</label>
                                </div>
                                <div class="form-group ml-1">
                                    <input type="hidden" name="client_id" id="clientId" value="">
                                    <input type="hidden" name="term" value="{{ $year . '-' . $month }}">
                                    <input type="submit" id="sendInvoiceBtn" class="btn btn-success text-light" value="Send Invoice" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
