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
                $monthToSubtract = 1;
            @endphp
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr class="text-center sticky-top">
                        <th></th>
                        @if (request()->invoice_status == "sent" || $invoiceStatus == 'sent')
                            <th>Client</th>
                        @endif
                        <th class="w-150">Project</th>
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
                            <th>Email</th>
                        @elseif (request()->invoice_status == "ready")
                            <th>EffortSheet</th>
                            <th>Preview Invoice</th>
                            <th>Action</th>   
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if((request()->invoice_status == 'sent' || $invoiceStatus == 'sent') && $invoices->isNotEmpty())
                        @foreach ($invoices as $invoice)
                            @php
                                $invoiceYear = $invoice->sent_on->subMonth()->year;
                                $invoiceData = [
                                    'projectName' => optional($invoice->project)->name ?: ($invoice->client->name . 'Projects'),
                                    'billingPersonName' => optional($invoice->client->billing_contact)->name,
                                    'billingPersonFirstName' => optional($invoice->client->billing_contact)->first_name,
                                    'billingPersonEmail' => optional($invoice->client->billing_contact)->email,
                                    'senderEmail' => config('invoice.mail.send-invoice.email'),
                                    'term' => $invoice->term,
                                    'year' => $invoiceYear,
                                    'emailSubject' => $invoiceReminderEmailSubject,
                                    'emailBody' => $invoiceReminderEmailBody,
                                    'invoiceId' => $invoice->id,
                                    'invoiceNumber' => $invoice->invoice_number,
                                    'invoiceAmount' => $invoice->invoiceAmount(),
                                    'bccEmails' => $invoice->client->bcc_emails,
                                    'ccEmails' => $invoice->client->cc_emails
                                ];
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $invoice->client->name }}</td>
                                <td>{{ optional($invoice->project)->name ?: ($invoice->client->name . ' Projects') }}</td>
                                <td><a href="{{ route('invoice.edit', $invoice) }}">{{ $invoice->invoice_number }}</a></td>
                                <td>{{ $invoice->invoiceAmount() }}</td>
                                <td class="text-center">{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                                <td class='{{ $invoice->shouldHighlighted() ? 'font-weight-bold text-danger ' : '' }} text-center'>
                                    {{ $invoice->receivable_date->format(config('invoice.default-date-format')) }}
                                </td>
                                <td class="{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }} text-center">
                                    {{ $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '' }}
                                </td>
                                <td class="{{ $invoice->shouldHighlighted() ? 'font-weight-bold text-danger' : '' }}{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }} text-center">
                                    {{ $invoice->shouldHighlighted() ? __('Overdue') : $invoice->status }}
                                </td>
                                <td class="text-center">
                                    @if($invoice->reminder_mail_count)
                                        <div class="text-success">{{ __('Reminder Sent') }}</div>
                                    @elseif($invoice->shouldHighlighted())
                                        <div class="btn btn-sm btn-primary send-reminder" data-invoice-data="{{ json_encode($invoiceData) }}" data-toggle="modal" data-target="#invoiceReminder" >{{ __('Reminder') }}</div>
                                    @else
                                        <div> - </div> 
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @elseif((request()->invoice_status == 'ready'  || $invoiceStatus == 'ready') && $clientsReadyToSendInvoicesData->isNotEmpty())
                        <tr class="font-weight-bold bg-theme-warning-lighter">
                            <td colspan="8">{{ __('Client Level Billing Projects') }}</td>
                        </tr>
                        @php
                            $index = 0;
                        @endphp
                        @foreach ($clientsReadyToSendInvoicesData as $client)
                            @if ($client->getClientLevelProjectsBillableHoursForInvoice() == 0)
                                @continue
                            @endif
                            @php
                                $index++;
                                $amount = config('constants.currency.' . $client->currency . '.symbol') . $client->getTotalPayableAmountForTerm($monthToSubtract, $client->clientLevelBillingProjects);
                                $billingStartMonth = $client->getMonthStartDateAttribute($monthToSubtract)->format('M');
                                $billingEndMonth = $client->getClientMonthEndDateAttribute($monthToSubtract)->format('M');
                                $monthName = $client->getClientMonthEndDateAttribute($monthToSubtract)->format('F');
                                $termText = $billingStartMonth;
                                $invoiceData = [
                                    'projectName' => $client->name . ' Projects',
                                    'billingPersonName' => optional($client->billing_contact)->name,
                                    'billingPersonFirstName' => optional($client->billing_contact)->first_name,
                                    'billingPersonEmail' => optional($client->billing_contact)->email,
                                    'senderEmail' => config('invoice.mail.send-invoice.email'),
                                    'invoiceNumber' => str_replace('-', '', $client->next_invoice_number),
                                    'totalAmount' => $amount,
                                    'year' => $year,
                                    'term' => $billingStartMonth != $billingEndMonth ? $termText . ' - ' . $billingEndMonth : $monthName,
                                    'emailSubject' => $sendInvoiceEmailSubject,
                                    'emailBody' => $sendInvoiceEmailBody,
                                    'clientId' => $client->id,
                                    'projectId' => null,
                                    'bccEmails' => $client->bcc_emails,
                                    'ccEmails' => $client->cc_emails
                                ];
                            @endphp
                            <tr>
                                <td>{{ $index }}</td>
                                <td>
                                    {{ $client->name . ' Projects' }}
                                </td>
                                <td>{{ config('constants.currency.' . $client->currency . '.symbol') . '' . $client->billingDetails->service_rates . __('/hour')}}</td>
                                <td>
                                    {{ $client->getClientLevelProjectsBillableHoursForInvoice() }}
                                    {{-- <i class="pt-1 ml-1 fa fa-external-link-square" data-toggle="modal" data-target="#InvoiceDetailsForClient{{ $client->id }}"></i> --}}
                                </td>
                                <td>{{ $amount }}</td>
                                <td align="center"> <a class="btn btn-sm btn-info text-light" href="{{ $client->effort_sheet_url }}" target="_blank">{{ __('Link') }}</a></td>
                                <td class="text-center">
                                    <form action="{{ route('invoice.generate-invoice') }}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name='client_id' value="{{ $client->id }}">
                                        <input type='submit' class="btn btn-sm btn-info text-light" value="Preview">
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="btn btn-sm btn-success text-light show-preview" data-invoice-data="{{ json_encode($invoiceData) }}">{{ __('View Mail') }}</div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($index == 0)
                            <tr><td colspan=9 class="text-center fz-24 text-theme-gray">No invoices available</td></tr>
                        @endif
                        <tr class="font-weight-bold bg-theme-warning-lighter">
                            <td colspan="8">{{ __('Project Level Billing Projects') }}</td>
                        </tr>
                        @php
                            $index = 0;
                        @endphp
                        @foreach ($projectsReadyToSendInvoicesData as $project)
                            @if ($project->getBillableHoursForMonth($monthToSubtract) == 0)
                                @continue
                            @endif
                            @php
                                $index++;
                                $amount = config('constants.currency.' . $project->client->currency . '.symbol') . $project->getTotalPayableAmountForTerm($monthToSubtract);
                                $billingStartMonth = $project->client->getMonthStartDateAttribute($monthToSubtract)->format('M');
                                $billingEndMonth = $project->client->getClientMonthEndDateAttribute($monthToSubtract)->format('M');
                                $monthName = $project->client->getClientMonthEndDateAttribute($monthToSubtract)->format('F');
                                $termText = $billingStartMonth;
                                $invoiceData = [
                                    'projectName' => $project->name,
                                    'billingPersonName' => optional($project->client->billing_contact)->name,
                                    'billingPersonFirstName' => optional($project->client->billing_contact)->first_name,
                                    'billingPersonEmail' => optional($project->client->billing_contact)->email,
                                    'senderEmail' => config('invoice.mail.send-invoice.email'),
                                    'invoiceNumber' => str_replace('-', '', $project->next_invoice_number),
                                    'totalAmount' => $amount,
                                    'year' => $year,
                                    'term' => $billingStartMonth != $billingEndMonth ? $termText . ' - ' . $billingEndMonth : $monthName,
                                    'emailSubject' => $sendInvoiceEmailSubject,
                                    'emailBody' => $sendInvoiceEmailBody,
                                    'projectId' => $project->id,
                                    'clientId' => null,
                                    'bccEmails' => $project->client->bcc_emails,
                                    'ccEmails' => $project->client->cc_emails
                                ];
                            @endphp
                            <tr>
                                <td>{{ $index }}</td>
                                <td>
                                    {{ $project->name }}
                                </td>
                                <td>{{ config('constants.currency.' . $project->client->currency . '.symbol') . '' . $project->client->billingDetails->service_rates . __('/hour')}}</td>
                                <td>{{ $project->getBillableHoursForMonth($monthToSubtract) }}</td>
                                <td>{{ $amount }}</td>
                                <td align="center"> <a class="btn btn-sm btn-info text-light" href="{{ $project->effort_sheet_url }}" target="_blank">{{ __('Link') }}</a></td>
                                <td class="text-center">
                                    <form action="{{ route('invoice.generate-invoice') }}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name='project_id' value="{{ $project->id }}">
                                        <input type='submit' class="btn btn-sm btn-info text-light" value="Preview">
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="btn btn-sm btn-success text-light show-preview" data-invoice-data="{{ json_encode($invoiceData) }}">{{ __('View Mail') }}</div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($index == 0)
                            <tr><td colspan=9 class="text-center fz-24 text-theme-gray">No invoices available</td></tr>
                        @endif
                    @else
                        <tr><td colspan=9 class="text-center fz-24 text-theme-gray py-6">No invoices available</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
        @foreach ($clientsReadyToSendInvoicesData as $client)
            @include(
                'invoice::subviews.invoice-report.invoice-details-modal', 
                [
                    'modalId' => "InvoiceDetailsForClient" . $client->id,
                    'teamMembers' => $client->TeamMembersEffortData($monthToSubtract)
                ]
            )
        @endforeach
    </div>
    @if(request()->invoice_status == 'ready' || $invoiceStatus == 'ready')
       @include('invoice::modals.invoice-email-preview')
    @endif
    @include('invoice::modals.invoice-reminder')
@endsection
