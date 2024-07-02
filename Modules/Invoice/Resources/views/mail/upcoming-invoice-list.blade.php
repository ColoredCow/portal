<div>
    <p>Hello Finance Team!</p>
    <p>Please find a list of pending invoices.</p>
    {{-- <p>Total unpaid invoices: {{ $upcomingInvoices->count() }}</p> --}}

    <div>
        <table style="border: 1px solid #000; border-collapse: collapse;">
            <thead>
                <th>Project name</th>
                <th>Invoice Date</th>
                <th>Delivery Report</th>
            </thead>
            <tbody>
                @foreach($upcomingInvoices as $index => $invoice)
                    <tr style='border-top: 1px solid #000'>
                        <td style="padding-right: 10px;">{{$invoice->project->name}}</td>
                        <td style="padding-right: 10px;">{{ $invoice->invoice_date}}</td>
                        <td>
                            @if ($invoice['delivery_report'])
                                <a id="delivery_report_{{ $index }}" href="{{ route('delivery-report.show', $invoice['id'])}}" target="_blank">
                                    <span class="mr-1 underline theme-info fz-16">{{ basename($invoice['delivery_report']) }}</span>
                                </a>
                            @else
                                Not Uploaded Yet.
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
