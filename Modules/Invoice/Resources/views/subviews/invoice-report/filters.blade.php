<form action="{{ route('invoice.yearly-report')  }}" id="yearlyInvoiceFilterForm">
    <div class="d-flex">
        <div class='form-group mr-4 w-300'>
            <select class="form-control bg-light" name="client_id"
                onchange="document.getElementById('yearlyInvoiceFilterForm').submit();">
                <option {{ request()->input('client_id') == '' ? "selected=selected" : '' }} value="">All clients</option>
                @foreach($clients as $client)
                <option {{ request()->input('client_id') == $client->id ? "selected=selected" : '' }} value="{{$client->id}}">{{$client->name}}</option>
                @endforeach
            </select>
        </div>

        <div class='form-group mr-4 w-180'>
            <select class="form-control bg-light" name="invoiceYear"
                onchange="document.getElementById('yearlyInvoiceFilterForm').submit();">
                <option {{ request()->input('invoiceYear', null) == 'all-years' ? "selected=selected" : '' }} value="all-years">All years</option>
                @for($Invoiceyear=2017; $Invoiceyear<today()->addYear(2)->year; $Invoiceyear++)
                <option {{ request()->input('invoiceYear') == $Invoiceyear || (!request()->has('invoiceYear') && today()->year == $Invoiceyear) ? "selected=selected" : '' }} value={{$Invoiceyear}}>{{$Invoiceyear}}-{{$Invoiceyear + 1}}</option>
                @endfor
            </select>
        </div>
    </div>
</form>