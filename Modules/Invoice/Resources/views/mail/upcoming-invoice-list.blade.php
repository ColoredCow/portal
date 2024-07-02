<div>
    <p>Hello Finance Team!</p>
    <p>Please find a list of scheduled invoices.</p>
    <p>Total upcoming invoices: {{ $upcomingInvoices->count() }}</p>

    <div>
        <table style="border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <th style='border: 1px solid #000'>Project name</th>
                <th style='border: 1px solid #000'>Invoice Date</th>
                <th style='border: 1px solid #000'>Delivery Report</th>
            </thead>
            <tbody>
                @foreach($upcomingInvoices as $index => $invoice)
                    <tr style='border: 1px solid #000'>
                        <td style='border: 1px solid #000'>{{$invoice->project->name}}</td>
                        <td style='border: 1px solid #000'>{{ $invoice->invoice_date}}</td>
                        <td style='border: 1px solid #000'>
                            @if ($invoice['delivery_report'])
                                <a id="delivery_report_{{ $index }}" href="{{ route('delivery-report.show', $invoice['id'])}}" target="_blank">
                                    <span class="mr-1 underline theme-info fz-16">{{ basename($invoice['delivery_report']) }}</span>
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

    <p><a href="{{ route('invoice.index', ['invoice_status' => 'scheduled']) }}"> You can see more details here. </a></p>

    Please reach out in case you want to made some changes in this email. 
</div>
