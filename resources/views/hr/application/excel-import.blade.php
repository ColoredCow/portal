<div class="modal fade" id="excelImport" tabindex="-1" role="dialog" aria-labelledby="excelImport"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Excel File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
         
            <div class="modal-body">
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
                <button type="button" class="btn btn-primary">Start Import</button>
            </div>
        </div>
        </form>
    </div>
</div>