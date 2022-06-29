<div>
    <p>Hello Finance Team!</p>
    <p>Please find a list of pending invoices.</p>
    <p>Total unpaid invoices: {{ $unpaidInvoices->count() }}</p>

    <div>
        <table style="border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <th>Project name</th>
                <th>Sent on</th>
                <th>Expected Date</th>
            </thead>

            <tbody>
                @foreach($unpaidInvoices as $invoice)
                    <tr style='border-top: 1px solid #000'>
                        <td style="padding-right: 10px;">{{ optional($invoice->project)->name ?: ($invoice->client->name . ' Projects') }}</td>
                        <td style="padding-right: 10px;">{{ $invoice->created_at->format(config('invoice.default-date-format')) }}</td>
                        <td style="padding-right: 10px; {{ $invoice->shouldHighlighted() ? 'color: red; border-top: 1px solid #000' : 'border-top: 1px solid #000' }}">{{ $invoice->receivable_date->format(config('invoice.default-date-format')) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p><a href={{ route('invoice.index') }}> You can see more details here. </a></p>

    Please reach out in case you want to made some changes in this email. 
</div>
