<form action="{{ route('invoice.invoice-settle')  }}" id="invoiceFilterForm">
    <input type="hidden" name="invoice_status" value="{{ request()->input('invoice_status', 'sent') }}">
    <div class="d-flex">
        <div class="form-row row-cols-1 row-cols-sm-2 row-cols-md-4 no-gutters">
            <div class="col-6 p-0">
                <div class='form-group mr-2 mr-md-4 px-3 px-md-0 w-168'>
                    <select class="form-control bg-light" name="year"  onchange="document.getElementById('invoiceFilterForm').submit();">
                        <option {{ $filters['year'] == '' ? "selected=selected" : '' }} value="">All Years</option>
                        @php $year = now()->year; @endphp
                        @while ($year != 2015)
                            <option {{ $filters['year'] == $year ? "selected=selected" : '' }} value="{{ $year }}">{{ $year }}</option>
                            @php $year--; @endphp
                        @endwhile
                    </select>
                </div>
            </div>

            <div class="col-6 p-0">
                <div class='form-group mr-2 mr-md-4 px-3 px-md-0 w-168'>
                    <select class="form-control bg-light" name="month" onchange="document.getElementById('invoiceFilterForm').submit();">
                        <option {{ $filters['month'] == '' ? "selected=selected" : '' }} value="">All Months</option>
                        <option {{ $filters['month'] == '01' ? "selected=selected" : '' }} value="01">January</option>
                        <option {{ $filters['month'] == '02' ? "selected=selected" : '' }} value="02">February</option>
                        <option {{ $filters['month'] == '03' ? "selected=selected" : '' }} value="03">March</option>
                        <option {{ $filters['month'] == '04' ? "selected=selected" : '' }} value="04">April</option>
                        <option {{ $filters['month'] == '05' ? "selected=selected" : '' }} value="05">May</option>
                        <option {{ $filters['month'] == '06' ? "selected=selected" : '' }} value="06">June</option>
                        <option {{ $filters['month'] == '07' ? "selected=selected" : '' }} value="07">July</option>
                        <option {{ $filters['month'] == '08' ? "selected=selected" : '' }} value="08">August</option>
                        <option {{ $filters['month'] == '09' ? "selected=selected" : '' }} value="09">September</option>
                        <option {{ $filters['month'] == '10' ? "selected=selected" : '' }} value="10">October</option>
                        <option {{ $filters['month'] == '11' ? "selected=selected" : '' }} value="11">November</option>
                        <option {{ $filters['month'] == '11' ? "selected=selected" : '' }} value="11">December</option>
                    </select>
                </div>
            </div>

            <div class="col-6 p-0">
                <div class='form-group mr-2 mr-md-4 px-3 px-md-0 w-168'>
                    <select class="form-control bg-light" name="status"  onchange="document.getElementById('invoiceFilterForm').submit();">
                        <option {{ $filters['status'] == '' ? "selected=selected" : '' }} value="">All Status</option>
                        <option {{ $filters['status'] == 'sent' ? "selected=selected" : '' }} value="sent">Pending</option>
                        <option {{ $filters['status'] == 'paid' ? "selected=selected" : '' }} value="paid">Paid</option>
                        <option {{ $filters['status'] == 'disputed' ? "selected=selected" : '' }} value="disputed">Disputed</option>
                    </select>
                </div>
            </div>  

            <div class="col-6 p-0">
                <div class='form-group mr-2 mr-md-4 px-3 px-md-0 w-168'>
                    @if(! request()->client_id)
                        <select class="form-control bg-light" name="client_id"  onchange="document.getElementById('invoiceFilterForm').submit();">
                            <option {{ $filters['client_id'] == '' ? "selected=selected" : '' }} value="">All clients</option>
                            @foreach ($clients as $client)
                                <option {{ $filters['client_id'] == $client->id ? "selected=selected" : '' }} value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>