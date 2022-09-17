<form action="{{ route('revenue.proceeds.index')  }}" id="revenueFilterForm">
    <input type="hidden" name="" value="">
    <div class="d-flex">
        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="year"  onchange="document.getElementById('revenueFilterForm').submit();">
                <option {{ $filters['year'] == '' ? "selected=selected" : '' }} value="">All Years</option>
                @php $year = now()->year; @endphp
                @while ($year != 2017)
                    <option {{ $filters['year'] == $year ? "selected=selected" : '' }} value="{{ $year }}">{{ $year }}</option>
                    @php $year--; @endphp
                @endwhile
            </select>
        </div>
        
        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="month" onchange="document.getElementById('revenueFilterForm').submit();">
                <option {{ $filters['month'] == '' ? "selected=selected" : '' }} value="">All months</option>
                @foreach (config('constants.months') as $months => $month)
                <option {{ $filters['month'] == $months ? "selected=selected" : '' }} value="{{ $months }}">{{ $month }}</option>
                @endforeach
            </select>
        </div>
        
    </div>
</form>
