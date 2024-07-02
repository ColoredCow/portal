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
    </style>
    <p>Hi, {{ $keyAccountManager->name }}</p>
    <p>Hope you are doing well.</p>
    <p>There are some scheduled invoices that are missing delivery reports. Please take action to provide the necessary reports so that the finance team can proceed with the invoice generation process.</p>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Project Name</th>
                <th scope="col">Invoice Date</th>
                <th scope="col">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keyAccountManager->invoiceTerms as $invoiceTerm)
            <tr>
                <td>
                    <a href="{{ route('project.edit', $invoiceTerm->project->id) }}">{{ $invoiceTerm->project->name }}</a>
                </td>
                <td>{{ \Carbon\Carbon::parse($invoiceTerm->invoice_date)->format('d-m-Y') }}</td>
                <td>{{ $invoiceTerm->amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>

    <br>
    <p class="line">Thanks,</p>
    <p class="line">ColoredCow Portal</p>
</div>
