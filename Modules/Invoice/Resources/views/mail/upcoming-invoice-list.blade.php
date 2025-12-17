<div>
    <style>
        .line {
            line-height: 1px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .text-danger {
            color: red;
        }
        .theme-info {
            color: blue;
        }
        .underline {
            text-decoration: underline;
        }
    </style>
    <p>Hello Finance Team!</p>
    <p>Please find a list of scheduled invoices.</p>
    <p>Total upcoming invoices: {{ $upcomingInvoices->count() }}</p>

    <div>
        <table class="table">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Invoice Date</th>
                    <th>Delivery Report</th>
                </tr>
            </thead>
            <tbody>
                @foreach($upcomingInvoices as $index => $invoice)
                    <tr>
                        <td>{{ $invoice->project->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</td>
                        <td>
                            @if ($invoice->delivery_report)
                                <a id="delivery_report_{{ $index }}" href="{{ route('delivery-report.show', $invoice->id) }}" target="_blank">
                                    <span class="mr-1 underline theme-info fz-16">{{ basename($invoice->delivery_report) }}</span>
                                </a>
                            @else
                                <span class="text-danger">Not Uploaded Yet.</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p><a href="{{ route('invoice.index', ['invoice_status' => 'scheduled']) }}">You can see more details here.</a></p>

    <p>Please reach out in case you want to make some changes to this email.</p>
</div>
