<form action="{{ route('invoice.details')  }}" id="invoiceFilterForm">
    <div class="d-flex">
        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="clients" onchange="document.getElementById('invoiceFilterForm').submit();">
                <option {{ request()->input('clients') == '' ? "selected=selected" : '' }} value="">All clients</option>
                @foreach($invoices as $invoice)
                <option request()->input('clients') == $invoice->client->name ? "selected=selected" : '' }} value="{{ $invoice->client->name }}">{{ $invoice->client->name }}</option>
                @endforeach
            </select>
        </div>

        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="month"
                onchange="document.getElementById('invoiceFilterForm').submit();">
                <option {{ request()->input('month') == '' ? "selected=selected" : '' }} value="">All Months</option>
                <option {{ request()->input('month') == '01' ? "selected=selected" : '' }} value="01">January</option>
                <option {{ request()->input('month') == '02' ? "selected=selected" : '' }} value="02">February</option>
                <option {{ request()->input('month') == '03' ? "selected=selected" : '' }} value="03">March</option>
                <option {{ request()->input('month') == '04' ? "selected=selected" : '' }} value="04">April</option>
                <option {{ request()->input('month') == '05' ? "selected=selected" : '' }} value="05">May</option>
                <option {{ request()->input('month') == '06' ? "selected=selected" : '' }} value="06">June</option>
                <option {{ request()->input('month') == '07' ? "selected=selected" : '' }} value="07">July</option>
                <option {{ request()->input('month') == '08' ? "selected=selected" : '' }} value="08">August</option>
                <option {{ request()->input('month') == '09' ? "selected=selected" : '' }} value="09">September</option>
                <option {{ request()->input('month') == '10' ? "selected=selected" : '' }} value="10">October</option>
                <option {{ request()->input('month') == '11' ? "selected=selected" : '' }} value="11">November</option>
                <option {{ request()->input('month') == '12' ? "selected=selected" : '' }} value="12">December</option>
            </select>
        </div>

        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="year" onchange="document.getElementById('invoiceFilterForm').submit();">
                <option {{ request()->input('year') == '' ? "selected=selected" : '' }} value="">All Years</option>
                @php $year = now()->year; @endphp
                @while ($year != 2015)
                <option {{ request()->input('year') == $year ? "selected=selected" : '' }} value="{{ $year }}">
                    {{ $year }}
                </option>
                @php $year--; @endphp
                @endwhile
            </select>
        </div>
    </div>
</form>