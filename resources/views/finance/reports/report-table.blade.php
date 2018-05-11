<div class="row" id="#report_table_{{ $type }}" v-show="showReportTable == '{{ $type }}'">
    <div class="col-md-12">
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Invoice</th>
                    <th>Sent on</th>
                    <th>Invoiced amount</th>
                    <th>GST</th>
                    <th>Received on</th>
                    <th>Received amount</th>
                    <th>TDS deducted</th>
                    <th>Bank charges</th>
                    <th>ST on Fund Transfer</th>
                    <th>Balance left</th>
                </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>
                    <a href="/finance/invoices/{{ $invoice->id }}/edit" target="_blank">
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
                    <div>{{ $invoice->client->name }}</div>
                </td>
                <td>{{ date(config('constants.display_date_format'), strtotime($invoice->sent_on)) }}</td>
                <td>{{ config('constants.currency.' . $invoice->currency_sent_amount . '.symbol') }}&nbsp;{{ $invoice->sent_amount }}</td>
                @if ($invoice->currency_sent_amount == 'INR' && $invoice->gst)
                    <td>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $invoice->gst }}</td>
                @else
                    <td>-</td>
                @endif
                @if ($invoice->status == 'paid')
                    <td>{{ date(config('constants.display_date_format'), strtotime($invoice->paid_on)) }}</td>
                    <td>
                        @php
                            if ($invoice->currency_paid_amount != 'INR') {
                                $conversionRate = $invoice->conversion_rate ?? 1;
                                $paidAmount = $invoice->paid_amount * $conversionRate;
                            } else {
                                $paidAmount = $invoice->paid_amount;
                            }
                        @endphp
                        {{ config("constants.currency.INR.symbol") }}&nbsp;{{ number_format((float)$paidAmount, 2, '.', '') }}
                    </td>
                    @if ($invoice->currency_sent_amount == 'INR' && $invoice->tds)
                        <td>{{ config('constants.currency.INR.symbol') }}&nbsp;{{ $invoice->tds }}</td>
                    @else
                        <td>-</td>
                    @endif
                    @if ($invoice->transaction_charge)
                        <td>{{ config("constants.currency.$invoice->currency_transaction_charge.symbol") }}&nbsp;{{ $invoice->transaction_charge }}</td>
                    @else
                        <td>-</td>
                    @endif
                    @if ($invoice->transaction_tax)
                        <td>{{ config("constants.currency.$invoice->currency_transaction_tax.symbol") }}&nbsp;{{ $invoice->transaction_tax }}</td>
                    @else
                        <td>-</td>
                    @endif
                    @if ($invoice->due_amount)
                        <td>{{ config("constants.currency.$invoice->currency_due_amount.symbol") }}&nbsp;{{ $invoice->due_amount }}</td>
                    @else
                        <td>-</td>
                    @endif
                @else
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                @endif
            </tr>
        @endforeach
            </tbody>
        </table>
    </div>
</div>
