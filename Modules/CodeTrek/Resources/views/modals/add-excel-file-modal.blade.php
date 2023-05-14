<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#excel_file">
    Import Excel File</button>
<div id="add_applicant_details_form">
    <div class="modal fade" id="excel_file" tabindex="-1" role="dialog" aria-labelledby="photoGalleryLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('codetrek.excel')}}" method="POST" id='excel_file' enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Excel File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="field-required">Upload File</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="excel_file" id="file"
                                        placeholder="Select Excel file" required="required"
                                        accept=".xlsx,.xls,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                    <label class="custom-file-label" for="customFile">Select Excel file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mx-3 mb-2">
                        <a href="{{ url('/sample-files/codeTrek_sample_file.xlsx') }}" class="text-underline"
                            href="">Download sample file </a>
                    </div>
                    <div class="float-right p-2">
                        <button type="submit" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save-btn">Start Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
