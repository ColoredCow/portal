<div>
    <p>Dear {{ config('invoice.ca-email.name') }}</p>
    <p>Please find the invoices for the month of {{ $monthYear }} for GSTR1 filing.</p>
    <div>
        <p>1. Indian Invoices <a href="{{ $invoicesFolderDetails['indian']['folderLink'] }}">{{ $invoicesFolderDetails['indian']['folderLink'] }}</a></p>
        <p>2. International invoices <a href="{{ $invoicesFolderDetails['international']['folderLink'] }}">{{ $invoicesFolderDetails['international']['folderLink'] }}</a></p>
    </div>
    <br>
    <p>Let me know if you have any questions.</p>
    <p>Thanks</p>
    <p>Mohit</p>
</div>
