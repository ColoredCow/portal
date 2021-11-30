<form action="{{ route('invoice.index')  }}" id="invoiceFilterForm">
    <div class="d-flex">
        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="year"  onchange="document.getElementById('invoiceFilterForm').submit();">
                <option {{ request()->input('year') == '' ? "selected=selected" : '' }} value="">All Years</option>
                @php $year = now()->year; @endphp
                @while ($year != 2015)
                    <option {{ request()->input('year') == $year ? "selected=selected" : '' }} value="{{ $year }}">{{ $year }}</option>
                    @php $year--; @endphp
                @endwhile
            </select>
        </div>

        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="month" onchange="document.getElementById('invoiceFilterForm').submit();">
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
            <select class="form-control bg-light" name="status"  onchange="document.getElementById('invoiceFilterForm').submit();">
                <option {{ request()->input('status') == '' ? "selected=selected" : '' }} value="">All Status
                </option>
                <option {{ request()->input('status') == 'sent' ? "selected=selected" : '' }} value="sent">Pending
                </option>
                <option {{ request()->input('status') == 'paid' ? "selected=selected" : '' }} value="paid">Paid</option>
            </select>
        </div>
        
        <div>
            <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#emailinvoicesmodal">Email Invoices</button>
        </div>
    </div>
</form>
<div class="container" id="vueContainer">   
    <div class="modal" id="emailinvoicesmodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Email Invoices</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{route("")}}" method ="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="recipient-email" class="col-sm-4 col-form-label">Recipient-Email:   </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="recipient-email" placeholder="Recipient Email">
                            </div>
                        </div>
                    </form>    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Email</button>
                </div>
            </div>
        </div>
    </div>
</div>
 