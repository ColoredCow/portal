@extends('invoice::layouts.master')
@section('content')
    <div class="container" id="vueContainer">
        <br>
        <?php $invoice_amount; ?>
        <?php $total_amount = 0;?>

        @includeWhen(session('success'), 'toast', ['message' => session('success')])
        <div class="d-flex justify-content-between">
            <h4 class="m-1 p-1 fz-28">Invoices</h4>
        </div>
        <br>
        @error('invoice_email')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
        @enderror
        <div>
            @include('invoice::index-filters')
        </div>
        <div class="form-row mb-4 d-flex justify-content-start align-items-center">
            <!-- @if (request()->invoice_status == 'sent' || $invoiceStatus == 'sent')
                <div class="font-muli-bold my-4">
                    Receivable amount (for client  - {{ $invoices[0]->client->name }}): &nbsp; ₹{{ $totalReceivableAmount * (1 + 0.18) }}
                </div>
            @endif -->
            <div class="form-group">
                <label for="amountPaid" class="field-required mr-3 pt-1">Received Amount</label>
                <div class="input-group flex-1 flex-column">
                    <input type="number" class="form-control" name="amount_paid" id="amountPaid" placeholder="Amount Received" required="required" step=".01" min="0">
                    <button type="submit" value="Submit" id="amount_submit" class="btn btn-primary mt-2 w-100">Submit</button>
                </div>
            </div>

            <div class="form-group ml-10">
                <label for="comments">Comments</label>
                <textarea name="comments" id="paidInvoiceComment" rows="5" class="form-control"></textarea>
            </div>
        </div>

        <div>
            @php
                $month = now()
                    ->subMonth()
                    ->format('m');
                $year = now()
                    ->subMonth()
                    ->format('Y');
                $monthToSubtract = 1;
                $quarter = now()->quarter;
            @endphp
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr class="text-center sticky-top">
                        <th></th>
                        {{-- @if (request()->invoice_status == 'sent' || $invoiceStatus == 'sent')
                            <th>Client</th>
                        @endif --}}
                        <th class="w-150">Project</th>
                        @if (request()->invoice_status == 'sent' || $invoiceStatus == 'sent')
                            <th>Invoice Number</th>
                        @else
                            <th>Rates</th>
                            <th>Billable Hours</th>
                        @endif
                        <th>Amount ( + taxes)</th>
                        @if (request()->invoice_status == 'sent' || $invoiceStatus == 'sent')
                            <th>Sent on</th>
                            <th>Due on</th>
                            <th>Paid on</th>
                            <th>Status</th>
                            <th>Email</th>
                            {{-- <th>Received Amount</th> --}}
                        @elseif (request()->invoice_status == 'ready')
                            <th>EffortSheet</th>
                            <th>Preview Invoice</th>
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="invoicesBody">
                    @if ((request()->invoice_status == 'sent' || $invoiceStatus == 'sent') && $invoices->isNotEmpty())
                    <?php $invoices_amount = [];
                    ?>
                        @foreach ($invoices as $key => $invoice)
                            @php
                                $invoiceYear = $invoice->client->billingDetails->billing_date == 1 ? $invoice->sent_on->subMonth()->year : $invoice->sent_on->year;
                                array_push($invoices_amount, $invoice->invoiceAmount());
                                $invoiceData = [
                                    'projectName' => optional($invoice->project)->name ?: $invoice->client->name . 'Projects',
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
                                    'ccEmails' => $invoice->client->cc_emails,
                                ];
                            @endphp
                            <tr id="row_<?php echo $key;?>">
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>{{ $invoice->client->name }}</td> --}}
                                <td>{{ optional($invoice->project)->name ?: $invoice->client->name . ' Projects' }}</td>
                                <td>
                                    {{-- <a href="{{ route('invoice.edit', $invoice) }}">{{ $invoice->invoice_number }}</a> --}}
                                    <div class="text-primary c-pointer" data-toggle="modal" data-target="#edit_invoice_details_form_{{$key}}">{{ $invoice->invoice_number }}</div>
                                </td>
                                <td>{{ $invoice->invoiceAmount() }}</td>
                                @php $total_amount += intval(ltrim($invoice->invoiceAmount(), "₹")) @endphp
                                <td class="text-center">
                                    {{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                                <td
                                    class='{{ $invoice->shouldHighlighted() ? 'font-weight-bold text-danger ' : '' }} text-center'>
                                    {{ $invoice->receivable_date->format(config('invoice.default-date-format')) }}
                                </td>
                                <td
                                    class="{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }} text-center">
                                    {{ $invoice->payment_at ? $invoice->payment_at->format(config('invoice.default-date-format')) : '' }}
                                </td> 
                                <td
                                    class="{{ $invoice->shouldHighlighted() ? 'font-weight-bold text-danger' : '' }}{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }} text-center">
                                    {{ $invoice->shouldHighlighted() ? __('Overdue') : $invoice->status }}
                                </td>
                                <td class="text-center">
                                    @if ($invoice->reminder_mail_count)
                                        <div class="text-success">{{ __('Reminder Sent') }}</div>
                                    @elseif($invoice->shouldHighlighted())
                                        <div class="btn btn-sm btn-primary send-reminder"
                                            data-invoice-data="{{ json_encode($invoiceData) }}" data-toggle="modal"
                                            data-target="#invoiceReminder">{{ __('Reminder') }}</div>
                                    @else
                                        <div> - </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @elseif(
                        (request()->invoice_status == 'ready' || $invoiceStatus == 'ready') &&
                            $clientsReadyToSendInvoicesData->isNotEmpty())
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
                                $currencySymbol = config('constants.currency.' . $client->currency . '.symbol');
                                if ($client->hasCustomInvoiceTemplate()) {
                                    $amount = $currencySymbol . ($client->getResourceBasedTotalAmount() + $client->getClientProjectsTotalLedgerAmount($quarter));
                                } else {
                                    $amount = $currencySymbol . $client->getTotalPayableAmountForTerm($monthToSubtract, $client->clientLevelBillingProjects);
                                }
                                $billingStartMonth = $client->getMonthStartDateAttribute($monthToSubtract)->format('M');
                                $billingEndMonth = $client->getMonthEndDateAttribute($monthToSubtract)->format('M');
                                $billingEndMonthYear = $client->getMonthEndDateAttribute($monthToSubtract)->format('Y');
                                $monthName = $client->getMonthEndDateAttribute($monthToSubtract)->format('F');
                                $termText = $billingStartMonth;
                                if (optional($client->billingDetails)->billing_frequency == config('client.billing-frequency.quarterly.id')) {
                                    $termText = today()
                                        ->startOfQuarter()
                                        ->format('M');
                                    $billingStartMonth = today()
                                        ->startOfQuarter()
                                        ->addQuarter()
                                        ->format('M');
                                    $billingEndMonth = today()
                                        ->endOfQuarter()
                                        ->format('M');
                                }
                                $invoiceData = [
                                    'projectName' => $client->name . ' Projects',
                                    'billingPersonName' => optional($client->billing_contact)->name,
                                    'billingPersonFirstName' => optional($client->billing_contact)->first_name,
                                    'billingPersonEmail' => optional($client->billing_contact)->email,
                                    'senderEmail' => config('invoice.mail.send-invoice.email'),
                                    'invoiceNumber' => $client->next_invoice_number,
                                    'totalAmount' => $amount,
                                    'year' => $billingEndMonthYear,
                                    'term' => $billingStartMonth != $billingEndMonth ? $termText . ' - ' . $billingEndMonth : $monthName,
                                    'emailSubject' => $sendInvoiceEmailSubject,
                                    'emailBody' => $sendInvoiceEmailBody,
                                    'clientId' => $client->id,
                                    'projectId' => null,
                                    'bccEmails' => $client->bcc_emails,
                                    'ccEmails' => $client->cc_emails,
                                ];
                            @endphp
                            <tr>
                                <td>{{ $index }}</td>
                                <td>
                                    {{ $client->name . ' Projects' }}
                                </td>
                                <td>{{ config('constants.currency.' . $client->currency . '.symbol') . '' . $client->billingDetails->service_rates . config('client.service-rate-terms.' . optional($client->billingDetails)->service_rate_term . '.short-label') }}
                                </td>
                                <td>
                                    @if (optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                        {{ __('-') }}
                                    @else
                                        {{ $client->getClientLevelProjectsBillableHoursForInvoice() }}
                                        {{-- <i class="pt-1 ml-1 fa fa-external-link-square" data-toggle="modal" data-target="#InvoiceDetailsForClient{{ $client->id }}"></i> --}}
                                    @endif
                                </td>
                                <td>{{ $amount }}</td>
                                <td align="center"> <a class="btn btn-sm btn-info text-light"
                                        href="{{ $client->effort_sheet_url }}" target="_blank">{{ __('Link') }}</a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('invoice.generate-invoice') }}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name='client_id' value="{{ $client->id }}">
                                        <input type='submit' class="btn btn-sm btn-info text-light" value="Preview">
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="btn btn-sm btn-success text-light show-preview"
                                        data-invoice-data="{{ json_encode($invoiceData) }}">{{ __('View Mail') }}</div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($index == 0)
                            <tr>
                                <td colspan=9 class="text-center fz-24 text-theme-gray">No invoices available</td>
                            </tr>
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
                                
                                $currencySymbol = config('constants.currency.' . $project->client->currency . '.symbol');
                                if ($project->hasCustomInvoiceTemplate()) {
                                    $amount = $currencySymbol . $project->getTotalLedgerAmount($quarter);
                                } elseif (optional($project->client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug')) {
                                    $amount = $currencySymbol . $project->getResourceBillableAmount();
                                } else {
                                    $amount = $currencySymbol . $project->getTotalPayableAmountForTerm($monthToSubtract);
                                }
                                $billingStartMonth = $project->client->getMonthStartDateAttribute($monthToSubtract)->format('M');
                                $billingEndMonth = $project->client->getMonthEndDateAttribute($monthToSubtract)->format('M');
                                $billingEndMonthYear = $project->client->getMonthEndDateAttribute($monthToSubtract)->format('Y');
                                $monthName = $project->client->getMonthEndDateAttribute($monthToSubtract)->format('F');
                                $termText = $billingStartMonth;
                                if (optional($project->client->billingDetails)->billing_frequency == config('client.billing-frequency.quarterly.id')) {
                                    $termText = today()
                                        ->startOfQuarter()
                                        ->format('M');
                                    $billingStartMonth = $termText = today()
                                        ->startOfQuarter()
                                        ->format('M');
                                    $billingEndMonth = $termText = today()
                                        ->endOfQuarter()
                                        ->format('M');
                                }
                                $invoiceData = [
                                    'projectName' => $project->name,
                                    'billingPersonName' => optional($project->client->billing_contact)->name,
                                    'billingPersonFirstName' => optional($project->client->billing_contact)->first_name,
                                    'billingPersonEmail' => optional($project->client->billing_contact)->email,
                                    'senderEmail' => config('invoice.mail.send-invoice.email'),
                                    'invoiceNumber' => str_replace('-', '', $project->next_invoice_number),
                                    'totalAmount' => $amount,
                                    'year' => $billingEndMonthYear,
                                    'term' => $billingStartMonth != $billingEndMonth ? $termText . ' - ' . $billingEndMonth : $monthName,
                                    'emailSubject' => $sendInvoiceEmailSubject,
                                    'emailBody' => $sendInvoiceEmailBody,
                                    'projectId' => $project->id,
                                    'clientId' => null,
                                    'bccEmails' => $project->client->bcc_emails,
                                    'ccEmails' => $project->client->cc_emails,
                                ];
                            @endphp
                            <tr>
                                <td>{{ $index }}</td>
                                <td>
                                    {{ $project->name }}
                                </td>
                                <td>{{ config('constants.currency.' . $project->client->currency . '.symbol') . '' . $project->client->billingDetails->service_rates . config('client.service-rate-terms.' . optional($project->client->billingDetails)->service_rate_term . '.short-label') }}
                                </td>
                                <td>
                                    @if (optional($project->client->billingDetails)->service_rate_term ==
                                            config('client.service-rate-terms.per_resource.slug'))
                                        {{ __('-') }}
                                    @else
                                        {{ $project->getBillableHoursForMonth($monthToSubtract) }}
                                    @endif
                                </td>
                                <td>{{ $amount }}</td>
                                <td align="center"> <a class="btn btn-sm btn-info text-light"
                                        href="{{ $project->effort_sheet_url }}" target="_blank">{{ __('Link') }}</a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('invoice.generate-invoice') }}" target="_blank" method="POST">
                                        @csrf
                                        <input type="hidden" name='project_id' value="{{ $project->id }}">
                                        <input type='submit' class="btn btn-sm btn-info text-light" value="Preview">
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="btn btn-sm btn-success text-light show-preview"
                                        data-invoice-data="{{ json_encode($invoiceData) }}">{{ __('View Mail') }}</div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($index == 0)
                            <tr>
                                <td colspan=9 class="text-center fz-24 text-theme-gray">No invoices available</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td colspan=9 class="text-center fz-24 text-theme-gray py-6">No invoices available</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @foreach ($clientsReadyToSendInvoicesData as $client)
            @include('invoice::subviews.invoice-report.invoice-details-modal', [
                'modalId' => 'InvoiceDetailsForClient' . $client->id,
                'teamMembers' => $client->teamMembersEffortData($monthToSubtract),
                ])
        @endforeach
    </div>
    @include('invoice::modals.invoice-reminder')
    @include('invoice::subviews.edit.invoice-details')
    
@endsection
@section('js_scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('paidInvoiceComment').addEventListener('keyup', function(event) {
            document.querySelectorAll("[id^='row_']").forEach(row => {
                row.style.backgroundColor = '';
            });
            parseComment(event.target.value);
        });

        function parseComment(comment) {
            let extractedNumbers = comment.match(/\d+(\.\d+)?/g);

            if (extractedNumbers && extractedNumbers.length > 0) {
                let lastNumber = extractedNumbers[extractedNumbers.length - 1];
                document.getElementById('amountPaid').value = lastNumber;
            }
        }

        function findSubsetWithSum(numbers, targetSum) {
            const powerSet = (array) => array.reduce((subsets, value) => subsets.concat(subsets.map(set => [value, ...set])), [[]]);
            const allSubsets = powerSet(numbers);
            const resultSubset = allSubsets.find(subset => {
                const subsetSum = subset.reduce((sum, [, num]) => {
                    const numericValue = parseFloat(num.replace(/[^\d.]/g, ''));
                    return sum + numericValue;
                }, 0);
                return subsetSum === targetSum;
            });
            return resultSubset || null;
        }

        document.getElementById('amount_submit').addEventListener('click', function(event) {
            event.preventDefault();
            
            const numbers =  @json($invoices_amount);
            const targetSum = parseFloat(document.getElementById('amountPaid').value) || 0;
            const subset = findSubsetWithSum(Object.entries(numbers), targetSum);

            if (subset) {
                subset.forEach(([key]) => {
                    const row = document.getElementById(`row_${key}`);
                    if (row) {
                        row.style.backgroundColor = 'lightgreen';
                    } else {
                        console.log(`No row found with id 'row_${key}'`);
                    }
                });
            } else {
                document.querySelectorAll("[id^='row_']").forEach(row => {
                    row.style.backgroundColor = '';
                });
            }
        });
    })
    </script>


