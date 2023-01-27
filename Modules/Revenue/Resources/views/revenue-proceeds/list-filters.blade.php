<form method="GET" action="{{ route('revenue.proceeds.index')  }}" id="revenueFilterForm">
    <input type="hidden" name="" value="">
    <div class="d-flex">
        <div class='form-group mr-4 w-168'>
            <select class="form-control bg-light" name="year"  onchange="document.getElementById('revenueFilterForm').submit();">
                @php $year = now()->year; @endphp
                @while ($year != 2017)
                    <option {{ $filters['year'] == $year ? "selected=selected" : '' }} value="{{ $year }}">{{ $year }}-{{ $year+1 }}</option>
                    @php $year--; @endphp
                @endwhile
            </select>
        </div>
        
    </div>
</form>
