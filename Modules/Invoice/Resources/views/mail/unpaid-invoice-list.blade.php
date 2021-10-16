<div>
    <p>Hello Finance Team!</p>
    <p>Please find a list of pending invoices.</p>
    <p>Total unpaid invoices: {{ $unpaidInvoices->count() }}</p>

    <div>
        <table class="border-top border-dark" style="border-collapse: collapse;">
            <thead>
                <th>Project name</th>
                <th>Sent on</th>
                <th>Expected Date</th>
            </thead>

            <tbody>
                @foreach($unpaidInvoices as $invoice)
                    <tr style='border-top: 1px solid #000'>
                        <td style="padding-right: 10px;">{{ $invoice->project->name }}</td>
                        <td style="padding-right: 10px;">{{ $invoice->created_at->format(config('invoice.default-date-format')) }}</td>
                        <td style="padding-right: 10px;" class="border-top border-dark {{ $invoice->shouldHighlighted() ? 'text-danger' : '' }}">{{ $invoice->receivable_date->format(config('invoice.default-date-format')) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p><a href={{ route('invoice.index') }}> You can see more details here. </a></p>

    Please reach out in case you want to made some changes in this email. 
</div>
