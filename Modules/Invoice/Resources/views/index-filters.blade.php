<form action="{{ route('invoice.index')  }}" id="invoiceFilterForm">
    <div class="d-flex">
        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="year" id="" onchange="document.getElementById('invoiceFilterForm').submit();">
                <option {{ request()->input('year') == '' ? "selected=selected" : '' }} value="">All Years</option>
                <option {{ request()->input('year') == '2020' ? "selected=selected" : '' }} value="2020">2020</option>
                <option {{ request()->input('year') == '2019' ? "selected=selected" : '' }} value="2019">2019</option>
                <option {{ request()->input('year') == '2018' ? "selected=selected" : '' }} value="2018">2018</option>
                <option {{ request()->input('year') == '2017' ? "selected=selected" : '' }} value="2017">2017</option>
                <option {{ request()->input('year') == '2016' ? "selected=selected" : '' }} value="2016">2016</option>
            </select>
        </div>

        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="month" id="" onchange="document.getElementById('invoiceFilterForm').submit();">
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
            <select class="form-control bg-light" name="status" id="" onchange="document.getElementById('invoiceFilterForm').submit();">
                <option {{ request()->input('status') == '' ? "selected=selected" : '' }} value="">All Status
                </option>
                <option {{ request()->input('status') == 'sent' ? "selected=selected" : '' }} value="sent">Pending
                </option>
                <option {{ request()->input('status') == 'paid' ? "selected=selected" : '' }} value="paid">Paid</option>
            </select>
        </div>

        {{-- <div class='form-group'>
            <div>
                <button type="submit" class="btn btn-info">Refresh</button>
            </div>
        </div> --}}
    </div>
</form>