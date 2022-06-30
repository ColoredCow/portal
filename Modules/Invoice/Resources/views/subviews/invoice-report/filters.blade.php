<form action="{{ route('invoice.yearly-report')  }}" id="yearlyInvoiceFilterForm">
    <div class="d-flex">
        <div class='form-group mr-4 w-300'>
            <select class="form-control bg-light" name="client_id"
                onchange="document.getElementById('yearlyInvoiceFilterForm').submit();">
                <option {{ request()->input('client_id') == '' ? "selected=selected" : '' }} value="">All clients</option>
                @foreach($invoices as $invoice)
                <option {{ request()->input('client_id') == $invoice->client->id ? "selected=selected" : '' }} value="{{$invoice->client->id}}">{{$invoice->client->name}}</option>
                @endforeach
            </select>
        </div>

        <div class='form-group mr-4 w-180'>
            <select class="form-control bg-light" name="invoiceYear"
                onchange="document.getElementById('yearlyInvoiceFilterForm').submit();">
                <option {{ request()->input('invoiceYear') == '' ? "selected=selected" : '' }} value="">Invoice year</option>
                @for($Invoiceyear=2000; $Invoiceyear<2025; $Invoiceyear++)
                <option {{ request()->input('invoiceYear') == $Invoiceyear ? "selected=selected" : '' }} value={{$Invoiceyear}}>{{$Invoiceyear}}-{{$Invoiceyear + 1}}</option>
                @endfor
            </select>
        </div>
    </div>

</form>