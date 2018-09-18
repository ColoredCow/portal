<div class="row" id="#report_table_{{ $type }}" v-show="showReportTable == '{{ $type }}'">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Invoice</th>
                    <th>Sent on</th>
                    <th>Invoiced amount</th>
                    <th>GST</th>
                    @if ($type == 'received')
                        <th>Received on</th>
                        <th>Received amount</th>
                        <th>TDS</th>
                        <th>Bank charges</th>
                        <th>ST on Forex</th>
                        {{-- <th>Balance left</th> --}}
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    @if ($type == 'received')
                        @foreach($invoice->payments as $payment)
                            <tr>
                                <td>
                                    <a href="{{ route('invoices.edit', $invoice) }}" target="_blank">
                                        @foreach ($invoice->projectStageBillings as $billing)
                                            {{ $loop->first ? '' : '|' }}
                                            {{ $billing->projectStage->project->name }}
                                        @endforeach
                                    </a>
                                    <span class="badge badge-pill badge-success">paid</span>
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
                                        if ($payment->currency != 'INR') {
                                            $conversionRate = $invoice->conversion_rate ?? 1;
                                            $paidAmount = $payment->amount * $conversionRate;
                                        } else {
                                            $paidAmount = $payment->amount;
                                        }
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
                    @else
                        <tr>
                            <td>
                                <a href="{{ route('invoices.edit', $invoice) }}" target="_blank">
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
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
