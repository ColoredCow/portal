<div class="modal fade" id="excelImport" tabindex="-1" role="dialog" aria-labelledby="excelImport"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('hr.applications.excel-import') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Excel File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
         
            <div class="modal-body">
                <div class="form-group ">
                    <label for="excel_file" class="field-required">Job</label>
                    <select class="form-control" name="job_id" id="job_id" required="required">
                        <option value="">Select Job</option>
                        @foreach($hrJobs as $hrJob)
                            <option value="{{ $hrJob->id }}">{{ $hrJob->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group ">
                    <label for="excel_file" class="field-required">Upload File</label>
                    <div class="d-flex">
                        <div class="custom-file mb-3">
                            <input type="file" id="excel_file" name="excel_file" class="custom-file-input" required="required">
                            <label for="resume" class="custom-file-label">Select excel file</label>
                        </div>
                    </div>
                </div>

                <div class="mt-auto">
                    <a href="{{ url('/sample-files/resume-excel.xlsx') }}" class="text-underline" href="">Download sample file </a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Start Import</button>
            </div>
        </div>
        </form>
    </div>
</div>