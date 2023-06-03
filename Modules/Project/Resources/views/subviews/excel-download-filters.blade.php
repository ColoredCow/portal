<div class="modal fade bd-create-modal-lg" id="modalExcelFilters" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text text-light" id="modalExcelFiltersLabel">Select Filters</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action=" {{ route('project.fte.export') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="d-flex">
                        <div class='form-group mr-4 w-168'>
                            <select class="form-control bg-light" name="year">
                                <option value="">Select year</option>
                                @php $year = now()->year; @endphp
                                @while ($year != 2015)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                    @php $year--; @endphp
                                @endwhile
                            </select>
                        </div>
                        <div class='form-group mr-4 w-168'>
                            <select class="form-control bg-light" name="month">
                                <option value="">Select Month</option>
                                @foreach (config('constants.months') as $monthNumber => $monthValue )
                                    <option value="{{ $monthNumber }}">{{ $monthValue }}</option> 
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="save-btn-action">Download for applied filter</button>
                </div>
            </form>
        </div>
    </div>
</div>