<div class="modal fade bd-create-modal-lg" id="modalExcelFilters" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
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
                            <select class="form-control bg-light" name="year" required>
                                <option value="">Select year</option>
                                @php $year = now()->year; @endphp
                                @while ($year != 2015)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                    @php $year--; @endphp
                                @endwhile
                            </select>
                        </div>
                        <div class='form-group mr-4 w-168'>
                            <select class="form-control bg-light" name="month" required>
                                <option value="">All Months</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
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